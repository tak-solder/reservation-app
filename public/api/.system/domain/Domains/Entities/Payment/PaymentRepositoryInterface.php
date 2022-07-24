<?php

namespace Domain\Domains\Entities\Payment;

use Domain\Domains\Entities\Payment\Provider\PaymentDataInterface;
use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Illuminate\Support\Collection;

interface PaymentRepositoryInterface
{
    public function findById(int $id): ?Payment;

    /**
     * @param int $userId
     * @return Collection|Payment[]
     */
    public function getPayments(
        int $userId
    ): Collection;

    public function createPayment(
        int $userId,
        PaymentProvider $provider,
        Collection $orders,
        int $amount
    ): Payment;

    public function updatePayment(Payment $payment): void;
}
