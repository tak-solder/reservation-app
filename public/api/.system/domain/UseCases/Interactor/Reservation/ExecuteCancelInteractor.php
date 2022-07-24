<?php

namespace Domain\UseCases\Interactor\Reservation;

use Domain\Domains\DomainService\Payment\PaymentService;
use Domain\Domains\DomainService\Reservation\ReservationService;
use Domain\Domains\Entities\Payment\Order\Order;
use Domain\Domains\Entities\Reservation\Cancel\CancelQuotation;
use Domain\Domains\ValueObject\Reservation\ReservationStatus;
use Domain\Exceptions\InconsistencyException;
use Domain\UseCases\Inputs\Reservation\ExecuteCancelValidatesInput;
use Domain\UseCases\Outputs\Reservation\ExecuteCancelOutput;

class ExecuteCancelInteractor
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

    /**
     * @param ExecuteCancelValidatesInput $input
     * @return ExecuteCancelOutput
     * @throws InconsistencyException
     * @throws \Domain\Exceptions\NotFoundEntityException
     */
    public function handle(ExecuteCancelValidatesInput $input): ExecuteCancelOutput
    {
        $reservation = $this->reservationService->findByReservationId($input->getUser(), $input->getReservationId());

        $payment = $this->paymentService->findPayment($input->getUser(), $reservation->getPaymentId());
        $order = $payment->getOrders()->first(fn(Order $order) => $order->getEventId() === $reservation->getEvent()->getId());
        if (!$order) {
            throw new \OutOfBoundsException("存在しないOrderのEventが指定されました reservationId={$reservation->getId()}, paymentId={$payment->getId()}, eventId={$reservation->getEvent()->getId()}");
        }

        $cancelQuotation = new CancelQuotation($reservation, $order);
        if ($cancelQuotation->getCancelRate() !== $input->getCancelRate()) {
            throw new InconsistencyException('キャンセル料率が変更されました。再度キャンセルをお試しください。');
        }


        transaction(function () use ($payment, $cancelQuotation, $reservation) {
            $this->reservationService->cancel($reservation, $cancelQuotation);
            $providerService = $this->paymentService->makeProviderService($payment->getProvider());
            $providerService->refundPayment($payment, $cancelQuotation->getCancelRefund());
        });


        return new ExecuteCancelOutput($cancelQuotation);
    }
}
