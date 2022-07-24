<?php

namespace Domain\Infrastructures\Api\PaymentProvider\Stripe;

use Domain\Domains\Entities\Payment\Provider\Stripe\Checkout\CheckoutRequest;
use Domain\Domains\Entities\Payment\Provider\Stripe\StripePaymentData;
use Domain\Domains\ValueObject\Payment\Item\PaymentItemType;
use Domain\Domains\ValueObject\Payment\ProviderPaymentStatus;

interface StripeRepositoryInterface
{
    public function checkout(CheckoutRequest $request): StripePaymentData;

    public function addItemPrice(PaymentItemType $itemType, int $amount): array;

    public function getProviderStatus(string $providerId): ProviderPaymentStatus;

    public function capture(string $providerId): void;

    public function refund(string $providerId, int $amount): void;
}
