<?php

namespace Domain\UseCases\Outputs\Payment;

use Domain\Domains\Entities\Reservation\Reservation;
use Domain\UseCases\Outputs\OutputInterface;

class CompleteOutput implements OutputInterface
{
    private ?Reservation $reservation;

    public function __construct(?Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function toArray()
    {
        return [
            'reservation' => $this->reservation ? $this->getReservation()->toArray() : null,
        ];
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }
}
