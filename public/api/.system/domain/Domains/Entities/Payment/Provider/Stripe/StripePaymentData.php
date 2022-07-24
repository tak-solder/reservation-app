<?php

namespace Domain\Domains\Entities\Payment\Provider\Stripe;

use Domain\Domains\Entities\Payment\Provider\PaymentDataInterface;
use Domain\Domains\ValueObject\Payment\PaymentProvider;

class StripePaymentData implements PaymentDataInterface
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getProvider(): PaymentProvider
    {
        return PaymentProvider::STRIPE();
    }

    public function getProviderId(): string
    {
        return $this->data['payment_intent'];
    }

    public function getCheckoutUrl(): string
    {
        return $this->data['url'];
    }

    public function toArray()
    {
        return $this->data;
    }
}
