<?php

namespace Domain\Infrastructures\Mock\Repositories;

use Domain\Domains\Entities\Event\Event;
use Domain\Domains\Entities\Event\EventRepositoryInterface;
use Domain\Domains\Entities\Reservation\Options\ReservationOption;
use Domain\Domains\Entities\Reservation\Reservation;
use Domain\Domains\Entities\Reservation\ReservationRepositoryInterface;
use Domain\Domains\ValueObject\Reservation\ReservationStatus;
use Domain\Infrastructures\Mock\Utilities\CollectionQueries;
use Illuminate\Support\Collection;

class MockReservationRepository implements ReservationRepositoryInterface
{
    use CollectionQueries;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        if (!$this->load()) {
            $this->collection = new Collection([
                new Reservation(
                    1,
                    9,
                    1,
                    3,
                    1650,
                    0,
                    ReservationStatus::FINISHED(),
                    new Collection(),
                ),
                new Reservation(
                    2,
                    10,
                    1,
                    4,
                    3300,
                    0,
                    ReservationStatus::CANCELED(),
                    new Collection([
                        'extraTime' => new ReservationOption("extraTime", 2),
                    ]),
                ),
                new Reservation(
                    3,
                    9,
                    2,
                    5,
                    1650,
                    0,
                    ReservationStatus::FINISHED(),
                    new Collection(),
                ),
            ]);
        }

        // インスタンス化時に最新のイベントデータを代入
        $this->collection->each(function (Reservation $reservation) use ($eventRepository) {
            $event = $eventRepository->findById($reservation->getEventId());
            $reservation->setEvent($event);
        });
    }

    public function findById(int $id): ?Reservation
    {
        return $this->find(fn(Reservation $reservation) => $reservation->getId() === $id);
    }

    public function getReservations(
        int $userId,
        ?ReservationStatus $status,
        int $limit,
        int $offset
    ): Collection {
        $filteredCollection = $this->filter(function (Reservation $reservation) use ($userId, $status) {
            if ($reservation->getUserId() !== $userId) {
                return false;
            }
            if ($status && $reservation->getStatus()->getValue() !== $status->getValue()) {
                return false;
            }

            return true;
        }, 'event.startDate');
        return $filteredCollection->slice($offset, $limit)->values();
    }

    /**
     * キャンセルされていない予約を取得
     * @param int $userId
     * @param int $eventId
     * @return Reservation|null
     */
    public function findAvailableReservation(int $userId, int $eventId): ?Reservation
    {
        return $this->find(fn(Reservation $reservation) => $reservation->getUserId() === $userId && $reservation->getEvent()->getId() === $eventId && !$reservation->getStatus()->equals(ReservationStatus::CANCELED()));
    }

    /**
     * @param int $paymentId
     * @return Collection|Reservation[]
     */
    public function getByPaymentId(int $paymentId): Collection
    {
        return $this->filter(fn(Reservation $reservation) => $reservation->getPaymentId() === $paymentId);
    }

    public function createReservation(Event $event, int $userId, int $paymentId, int $amount, ReservationStatus $status, Collection $options): Reservation
    {
        $reservation = new Reservation($this->getMaxId() + 1, $event->getId(), $userId, $paymentId, $amount, 0, $status, $options, $event);
        $this->collection->push($reservation);
        $this->persistence();
        return $reservation;
    }

    public function saveReservation(Reservation $reservation): void
    {
        $this->replaceEntity($reservation->getId(), $reservation);
        $this->persistence();
    }
}
