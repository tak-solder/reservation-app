<?php

namespace Domain\UseCases\Interactor\Reservation;

use Domain\Domains\DomainService\Reservation\ReservationService;
use Domain\UseCases\Inputs\Reservation\GetReservationValidatesInput;
use Domain\UseCases\Outputs\Reservation\GetReservationOutput;

class GetReservationInteractor
{
    private ReservationService $reservationService;

    public function __construct(
        ReservationService $reservationService
    ) {
        $this->reservationService = $reservationService;
    }

    public function handle(GetReservationValidatesInput $input): GetReservationOutput
    {
        $reservation = $this->reservationService->findByReservationId($input->getUser(), $input->getId());
        $reservation->getEvent()->getLocation()->setReservationStatus($reservation->getStatus());
        return new GetReservationOutput($reservation);
    }
}
