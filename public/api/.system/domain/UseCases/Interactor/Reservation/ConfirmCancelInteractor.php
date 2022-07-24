<?php

namespace Domain\UseCases\Interactor\Reservation;

use Domain\Domains\DomainService\Payment\PaymentService;
use Domain\Domains\DomainService\Reservation\ReservationService;
use Domain\Domains\Entities\Payment\Order\Order;
use Domain\Domains\Entities\Reservation\Cancel\CancelQuotation;
use Domain\Domains\ValueObject\Reservation\ReservationStatus;
use Domain\Exceptions\InconsistencyException;
use Domain\UseCases\Inputs\Reservation\ConfirmCancelValidatesInput;
use Domain\UseCases\Outputs\Reservation\ConfirmCancelOutput;

class ConfirmCancelInteractor
{
    private ReservationService $reservationService;
    private PaymentService $paymentService;

    public function __construct(
        ReservationService $reservationService,
        PaymentService $paymentService
    ) {
        $this->reservationService = $reservationService;
        $this->paymentService = $paymentService;
    }

    public function handle(ConfirmCancelValidatesInput $input): ConfirmCancelOutput
    {
        $reservation = $this->reservationService->findByReservationId($input->getUser(), $input->getReservationId());
        if (!$reservation->getStatus()->equals(ReservationStatus::APPLIED())) {
            throw new InconsistencyException('そのイベントはキャンセルできません');
        }

        $payment = $this->paymentService->findPayment($input->getUser(), $reservation->getPaymentId());
        $order = $payment->getOrders()->first(fn(Order $order) => $order->getEventId() === $reservation->getEvent()->getId());
        if (!$order) {
            throw new \OutOfBoundsException("存在しないOrderのEventが指定されました reservationId={$reservation->getId()}, paymentId={$payment->getId()}, eventId={$reservation->getEvent()->getId()}");
        }

        return new ConfirmCancelOutput(new CancelQuotation($reservation, $order));
    }
}
