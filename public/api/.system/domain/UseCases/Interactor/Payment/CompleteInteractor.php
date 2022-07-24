<?php

namespace Domain\UseCases\Interactor\Payment;

use Domain\Domains\DomainService\Reservation\ReservationService;
use Domain\UseCases\Inputs\Payment\CompleteValidatesInput;
use Domain\UseCases\Outputs\Payment\CompleteOutput;

class CompleteInteractor
{
    private ReservationService $reservationService;

    public function __construct(
        ReservationService $reservationService
    ) {
        $this->reservationService = $reservationService;
    }

    /**
     * @param CompleteValidatesInput $input
     * @return CompleteOutput
     * @throws \Domain\Exceptions\NotFoundEntityException
     */
    public function handle(CompleteValidatesInput $input): CompleteOutput
    {
        $reservation = $this->reservationService->findByPayment($input->getUser(), $input->getPaymentId());
        $reservation->getEvent()->getLocation()->setReservationStatus($reservation->getStatus());
        return new CompleteOutput($reservation);
    }
}
