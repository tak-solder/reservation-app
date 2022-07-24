<?php

namespace Domain\Domains\DomainService\Payment\Provider;

use Domain\Domains\Entities\Payment\Payment;
use Domain\Domains\Entities\User\User;
use Domain\Domains\ValueObject\Payment\ProviderPaymentStatus;
use Illuminate\Support\Collection;

interface PaymentProviderServiceInterface
{
    public function createPayment(
        User $user,
        Collection $orders,
        string $successUrl,
        string $cancelUrl
    ): Payment;

    public function getProviderStatus(Payment $payment): ProviderPaymentStatus;

    public function completePayment(Payment $payment): void;

    public function refundPayment(Payment $payment, int $amount): void;
}
