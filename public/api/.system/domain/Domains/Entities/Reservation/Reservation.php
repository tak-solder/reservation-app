<?php

namespace Domain\Domains\Entities\Reservation;

use Domain\Domains\Entities\EntityInterface;
use Domain\Domains\Entities\Event\Event;
use Domain\Domains\ValueObject\Reservation\ReservationStatus;
use Illuminate\Support\Collection;

class Reservation implements EntityInterface
{
    private int $id;
    private int $eventId;
    private int $userId;
    private int $paymentId;
    private int $amount;
    private int $refund;
    private ReservationStatus $status;
    private Collection $options;
    private ?Event $event;

    public function __construct(
        int $id,
        int $eventId,
        int $userId,
        int $paymentId,
        int $amount,
        int $refund,
        ReservationStatus $status,
        Collection $options,
        ?Event $event = null
    ) {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->userId = $userId;
        $this->paymentId = $paymentId;
        $this->amount = $amount;
        $this->refund = $refund;
        $this->status = $status;
        $this->options = $options;
        $this->event = $event;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getRefund(): int
    {
        return $this->refund;
    }

    public function setRefund(int $refund): void
    {
        $this->refund = $refund;
    }

    public function getStatus(): ReservationStatus
    {
        return $this->status;
    }

    public function setStatus(ReservationStatus $status): void
    {
        $this->status = $status;
    }

    public function getReservationOptions(): Collection
    {
        return $this->options;
    }

    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'eventId' => $this->eventId,
            'userId' => $this->userId,
            'paymentId' => $this->paymentId,
            'amount' => $this->amount,
            'refund' => $this->refund,
            'status' => $this->status->getValue(),
            'options' => $this->options->toArray(),
            'event' => $this->event ? $this->event->toArray() : null,
        ];
    }
}
