<?php

namespace Domain\Domains\Entities\Payment\Provider;

use Domain\Domains\Entities\EntityInterface;
use Domain\Domains\ValueObject\Payment\PaymentProvider;

interface PaymentDataInterface extends EntityInterface
{
    public function __construct(array $data);

    public function getProvider(): PaymentProvider;

    public function getProviderId(): string;

    public function getCheckoutUrl(): string;
}
