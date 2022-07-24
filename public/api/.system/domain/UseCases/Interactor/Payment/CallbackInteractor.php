<?php

namespace Domain\UseCases\Interactor\Payment;

use Domain\Domains\DomainService\Event\EventService;
use Domain\Domains\DomainService\Payment\PaymentService;
use Domain\Domains\DomainService\Reservation\ReservationService;
use Domain\Domains\Entities\Payment\Order\Order;
use Domain\Domains\ValueObject\Payment\ProviderPaymentStatus;
use Domain\Exceptions\InconsistencyException;
use Domain\UseCases\Inputs\Payment\CallbackValidatesInput;
use Domain\UseCases\Outputs\Payment\CallbackOutput;

class CallbackInteractor
{
    private EventService $eventService;
    private PaymentService $paymentService;
    private ReservationService $reservationService;

    public function __construct(
        EventService $eventService,
        PaymentService $paymentService,
        ReservationService $reservationService
    ) {
        $this->eventService = $eventService;
        $this->paymentService = $paymentService;
        $this->reservationService = $reservationService;
    }

    /**
     * @param CallbackValidatesInput $input
     * @return CallbackOutput
     * @throws InconsistencyException
     * @throws \Domain\Exceptions\NotFoundEntityException
     * @throws \Domain\Exceptions\UnexpectedValueObjectException
     */
    public function handle(CallbackValidatesInput $input): CallbackOutput
    {
        $user = $input->getUser();
        $payment = $this->paymentService->findPayment($input->getUser(), $input->getPaymentId());
        $providerService = $this->paymentService->makeProviderService($payment->getProvider());

        transaction(function () use ($user, $payment, $providerService) {
            $providerStatus = $providerService->getProviderStatus($payment);
            if ($providerStatus->equals(ProviderPaymentStatus::CREATED()) || $providerStatus->equals(ProviderPaymentStatus::CANCELED())) {
                throw new InconsistencyException("決済が完了していません");
            } elseif (!$providerStatus->equals(ProviderPaymentStatus::AUTHORIZATION())) {
                throw new InconsistencyException("既に処理済みの予約です");
            }

            $payment->getOrders()->map(function (Order $order) use ($user, $payment) {
                $event = $this->eventService->findEvent($order->getEventId(), $user->getId());
                return $this->reservationService->reserve($user, $payment, $event, $order->getReservationOptions());
            });

            $providerService->completePayment($payment);
        });

        return new CallbackOutput($payment);
    }
}
