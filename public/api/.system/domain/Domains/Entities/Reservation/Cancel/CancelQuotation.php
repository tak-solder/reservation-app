<?php

namespace Domain\Domains\Entities\Reservation\Cancel;

use Domain\Domains\Entities\EntityInterface;
use Domain\Domains\Entities\Payment\Order\Order;
use Domain\Domains\Entities\Reservation\Reservation;
use Illuminate\Support\Arr;

class CancelQuotation implements EntityInterface
{
    private Reservation $reservation;
    private Order $order;
    private int $cancelRate;
    private int $cancelCharge;
    private int $cancelRefund;

    private array $table;

    public function __construct(Reservation $reservation, Order $order)
    {
        $this->reservation = $reservation;
        $this->order = $order;
        // TODO #24 キャンセルポリシーの保管場所を検討
        $this->table = [
            7 * 86400 => 0,
            3 * 86400 => 75,
            0 => 100,
        ];
        krsort($this->table);

        $this->calculate();
    }

    private function calculate(): void
    {
        $diffSeconds = $this->reservation->getEvent()->getStartDate()->diffInSeconds();

        $this->cancelRate = Arr::first($this->table, fn($v, $key) => $key < $diffSeconds, 0);
        $this->cancelCharge = (int)ceil($this->cancelRate * $this->order->getAmount() / 100);
        $this->cancelRefund = $this->order->getAmount() - $this->cancelCharge;
    }

    public function getCancelRate(): int
    {
        return $this->cancelRate;
    }

    public function getCancelRefund(): int
    {
        return $this->cancelRefund;
    }

    public function toArray()
    {
        return [
            'reservationId' => $this->reservation->getId(),
            'eventId' => $this->reservation->getEvent()->getId(),
            'paidAmount' => $this->reservation->getAmount(),
            'cancelRate' => $this->cancelRate,
            'cancelCharge' => $this->cancelCharge,
            'cancelRefund' => $this->cancelRefund,
        ];
    }
}
