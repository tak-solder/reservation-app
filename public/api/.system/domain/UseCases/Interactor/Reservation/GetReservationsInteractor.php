<?php

namespace Domain\UseCases\Interactor\Reservation;

use Domain\Domains\DomainService\Reservation\ReservationService;
use Domain\Domains\Entities\Pager\SimplePager;
use Domain\UseCases\Inputs\Reservation\GetReservationsValidatesInput;
use Domain\UseCases\Outputs\Reservation\GetReservationsOutput;

class GetReservationsInteractor
{
    private ReservationService $reservationService;
    private int $perPage = 5;

    public function __construct(
        ReservationService $reservationService
    ) {
        $this->reservationService = $reservationService;
    }

    public function handle(GetReservationsValidatesInput $input): GetReservationsOutput
    {
        $page = $input->getPage();
        $offset = ($page - 1) * $this->perPage;

        $reservations = $this->reservationService->getReservations(
            $input->getUser(),
            $input->getStatus(),
            $this->perPage + 1,
            $offset
        );
        $hasMore = $reservations->count() > $this->perPage;
        $reservations = $reservations->slice(0, $this->perPage);

        $pager = new SimplePager($page, $hasMore);

        return new GetReservationsOutput($reservations, $pager);
    }
}
