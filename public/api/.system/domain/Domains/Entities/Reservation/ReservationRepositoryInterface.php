<?php

namespace Domain\Domains\Entities\Reservation;

use Domain\Domains\Entities\Event\Event;
use Domain\Domains\ValueObject\Reservation\ReservationStatus;
use Illuminate\Support\Collection;

interface ReservationRepositoryInterface
{
    public function findById(int $id): ?Reservation;

    /**
     * @param int $userId
     * @param ReservationStatus|null $status
     * @param int $limit
     * @param int $offset
     * @return Collection|Reservation[]
     */
    public function getReservations(
        int $userId,
        ?ReservationStatus $status,
        int $limit,
        int $offset
    ): Collection;

    public function findAvailableReservation(int $userId, int $eventId): ?Reservation;

    public function getByPaymentId(int $paymentId): Collection;

    public function createReservation(Event $event, int $userId, int $paymentId, int $amount, ReservationStatus $status, Collection $options): Reservation;

    public function saveReservation(Reservation $reservation): void;
}
