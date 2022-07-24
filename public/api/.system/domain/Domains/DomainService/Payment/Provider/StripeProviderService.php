<?php

namespace Domain\Domains\DomainService\Payment\Provider;

use Domain\Domains\DomainService\Event\EventService;
use Domain\Domains\DomainService\Payment\PaymentItemService;
use Domain\Domains\Entities\Event\Event;
use Domain\Domains\Entities\EventOption\EventOption;
use Domain\Domains\Entities\Payment\Order\Order;
use Domain\Domains\Entities\Payment\Payment;
use Domain\Domains\Entities\Payment\PaymentRepositoryInterface;
use Domain\Domains\Entities\Payment\Provider\Stripe\Checkout\CheckoutLineItem;
use Domain\Domains\Entities\Payment\Provider\Stripe\Checkout\CheckoutOrder;
use Domain\Domains\Entities\Payment\Provider\Stripe\Checkout\CheckoutRequest;
use Domain\Domains\Entities\Reservation\Options\ReservationOption;
use Domain\Domains\Entities\User\User;
use Domain\Domains\ValueObject\EventOption\OptionInputType;
use Domain\Domains\ValueObject\Payment\Item\PaymentItemType;
use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Domain\Domains\ValueObject\Payment\ProviderPaymentStatus;
use Domain\Exceptions\NotFoundEntityException;
use Domain\Infrastructures\Api\PaymentProvider\Stripe\StripeRepositoryInterface;
use Illuminate\Support\Collection;

class StripeProviderService implements PaymentProviderServiceInterface
{
    private EventService $eventService;
    private PaymentItemService $paymentItemService;
    private StripeRepositoryInterface $stripeRepository;
    private PaymentRepositoryInterface $paymentRepository;

    public function __construct(
        EventService $eventService,
        PaymentItemService $paymentItemService,
        StripeRepositoryInterface $stripeRepository,
        PaymentRepositoryInterface $paymentRepository
    ) {
        $this->eventService = $eventService;
        $this->paymentItemService = $paymentItemService;
        $this->stripeRepository = $stripeRepository;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @param User $user
     * @param Collection|Order[] $orders
     * @param string $successUrl
     * @param string $cancelUrl
     * @return Payment
     * @throws \Domain\Exceptions\UnexecutableMethodException
     */
    public function createPayment(User $user, Collection $orders, string $successUrl, string $cancelUrl): Payment
    {
        $userId = $user->getId();
        $checkoutOrders = $orders->map(function (Order $order) use ($user) {
            return $this->createCheckoutOrder($user, $order);
        });
        $amount = $checkoutOrders->sum(fn(CheckoutOrder $checkoutOrder) => $checkoutOrder->getTotalAmount());

        $payment = $this->paymentRepository->createPayment($userId, PaymentProvider::STRIPE(), $orders, $amount);
        $successUrl = str_replace('{paymentId}', (string) $payment->getId(), $successUrl);

        $request = new CheckoutRequest($payment->getId(), $checkoutOrders, $successUrl, $cancelUrl);
        $paymentData = $this->stripeRepository->checkout($request);

        $payment->requestPayment($paymentData);
        $this->paymentRepository->updatePayment($payment);

        return $payment;
    }

    /**
     * @param User $user
     * @param Order $order
     * @return CheckoutOrder
     * @throws NotFoundEntityException
     * @throws \Domain\Exceptions\InvalidValueException
     */
    private function createCheckoutOrder(User $user, Order $order): CheckoutOrder
    {
        $lineItems = new Collection();
        $event = $this->eventService->findEvent($order->getEventId(), $user->getId());
        $lineItems->push($this->getEventItem($event));
        foreach ($order->getReservationOptions() as $reservationOption) {
            if ($lineItem = $this->getOptionItem($event, $reservationOption)) {
                $lineItems->push($lineItem);
            }
        }

        $checkoutOrder = new CheckoutOrder($event->getId(), $lineItems);
        $order->setAmount($checkoutOrder->getTotalAmount());

        return $checkoutOrder;
    }

    private function getEventItem(Event $event): CheckoutLineItem
    {
        $item = $this->paymentItemService->findItem(PaymentProvider::STRIPE(), PaymentItemType::ENTRY(), $event->getCost());
        return new CheckoutLineItem($item->getId(), $item->getProviderId(), $item->getAmount(), 1);
    }

    private function getOptionItem(Event $event, ReservationOption $reservationOption): ?CheckoutLineItem
    {
        $eventOption = $event->getOptions()->first(fn(EventOption $eventOption) => $eventOption->getKey() === $reservationOption->getKey());
        if (!$eventOption) {
            throw new \UnexpectedValueException("存在しないオプションが選択されました: {$reservationOption->getKey()}");
        }

        /** @var EventOption $eventOption */
        if ($eventOption->getInputType()->equals(OptionInputType::QUANTITY())) {
            $amount = $eventOption->getCost();
            $quantity = $reservationOption->getValue();
        } else {
            throw new \UnexpectedValueException("不明なインプットタイプ: eventOption={$eventOption->getKey()}, inputType={$eventOption->getInputType()->getKey()}");
        }

        if (!$amount || !$quantity) {
            return null;
        }

        $item = $this->paymentItemService->findItem(PaymentProvider::STRIPE(), PaymentItemType::from($eventOption->getKey()), $amount);
        return new CheckoutLineItem($item->getId(), $item->getProviderId(), $item->getAmount(), $quantity);
    }

    /**
     * @param Payment $payment
     * @return ProviderPaymentStatus
     */
    public function getProviderStatus(Payment $payment): ProviderPaymentStatus
    {
        return $this->stripeRepository->getProviderStatus($payment->getProviderId());
    }

    /**
     * @param Payment $payment
     * @return void
     * @throws \Domain\Exceptions\UnexecutableMethodException
     */
    public function completePayment(Payment $payment): void
    {
        transaction(function () use ($payment) {
            $payment->completedPayment();
            $this->paymentRepository->updatePayment($payment);

            $this->stripeRepository->capture($payment->getProviderId());
        });
    }

    /**
     * @param Payment $payment
     * @param int $amount
     * @return void
     * @throws \Domain\Exceptions\InvalidValueException
     * @throws \Domain\Exceptions\UnexecutableMethodException
     */
    public function refundPayment(Payment $payment, int $amount): void
    {
        transaction(function () use ($payment, $amount) {
            $payment->refundPayment($amount);
            $this->paymentRepository->updatePayment($payment);

            if ($amount > 0) {
                $this->stripeRepository->refund($payment->getProviderId(), $amount);
            }
        });
    }
}
