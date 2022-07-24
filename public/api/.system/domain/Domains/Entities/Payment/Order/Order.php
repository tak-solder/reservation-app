<?php

namespace Domain\Domains\Entities\Payment\Order;

use Domain\Domains\Entities\EntityInterface;
use Domain\Domains\Entities\Reservation\Options\ReservationOption;
use Domain\Exceptions\InvalidValueException;
use Illuminate\Support\Collection;

class Order implements EntityInterface
{
    private int $eventId;
    private Collection $reservationOptions;
    private ?int $amount;

    public function __construct(
        int $eventId,
        Collection $reservationOptions,
        ?int $amount
    ) {
        $this->eventId = $eventId;
        $this->reservationOptions = $reservationOptions;
        $this->amount = $amount;
    }

    /**
     * @param int $amount
     * @return void
     * @throws InvalidValueException
     */
    public function setAmount(int $amount)
    {
        if ($amount < 0) {
            throw new InvalidValueException($this, 'amount', $amount);
        }
        $this->amount = $amount;
    }

    public function toArray()
    {
        return [
            'eventId' => $this->eventId,
            'reservationOptions' => $this->reservationOptions->toArray(),
            'amount' => $this->getAmount(),
        ];
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

    /**
     * @return Collection|ReservationOption[]
     */
    public function getReservationOptions(): Collection
    {
        return $this->reservationOptions;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
