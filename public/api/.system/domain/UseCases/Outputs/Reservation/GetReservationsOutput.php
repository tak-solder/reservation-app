<?php

namespace Domain\UseCases\Outputs\Reservation;

use Domain\Domains\Entities\Pager\SimplePager;
use Domain\UseCases\Outputs\OutputInterface;
use Illuminate\Support\Collection;

class GetReservationsOutput implements OutputInterface
{
    private Collection $reservations;
    private SimplePager $pager;

    public function __construct(Collection $reservations, SimplePager $pager)
    {
        $this->reservations = $reservations;
        $this->pager = $pager;
    }

    public function toArray()
    {
        return [
            'reservations' => $this->getReservations()->toArray(),
            'pager' => $this->pager->toArray(),
        ];
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }
}
