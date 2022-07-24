<?php

namespace Domain\UseCases\Interactor\Payment;

use Domain\Domains\DomainService\Event\EventService;
use Domain\Domains\DomainService\Payment\PaymentService;
use Domain\Domains\DomainService\Reservation\ReservationService;
use Domain\Domains\Entities\Payment\Order\Order;
use Domain\Exceptions\InconsistencyException;
use Domain\UseCases\Inputs\Payment\CheckoutValidatesInput;
use Domain\UseCases\Outputs\Payment\CheckoutOutput;

class CheckoutInteractor
{
    private EventService $eventService;
    private ReservationService $reservationService;
    private PaymentService $paymentService;

    public function __construct(
        EventService $eventService,
        ReservationService $reservationService,
        PaymentService $paymentService
    ) {
        $this->eventService = $eventService;
        $this->reservationService = $reservationService;
        $this->paymentService = $paymentService;
    }

    /**
     * @param CheckoutValidatesInput $input
     * @return CheckoutOutput
     * @throws InconsistencyException
     * @throws \Domain\Exceptions\NotFoundEntityException
     * @throws \Domain\Exceptions\UnexpectedValueObjectException
     */
    public function handle(CheckoutValidatesInput $input): CheckoutOutput
    {
        $user = $input->getUser();
        $provider = $input->getProvider();
        $providerService = $this->paymentService->makeProviderService($provider);

        $input->getOrders()->each(function (Order $order) use ($user) {
            $event = $this->eventService->findEvent($order->getEventId(), $user->getId());
            if (!$this->reservationService->canReserve($user, $event)) {
                throw new InconsistencyException("このイベントは予約できません");
            }
        });

        $payment = $providerService->createPayment($input->getUser(), $input->getOrders(), $input->getSuccessUrl(), $input->getCancelUrl());

        return new CheckoutOutput($payment->getPaymentData());
    }
}
