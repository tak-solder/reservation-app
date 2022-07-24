<?php

namespace Domain\Domains\ValueObject\Payment;

use MyCLabs\Enum\Enum;

/**
 * @method static self CREATED()
 * @method static self AUTHORIZATION()
 * @method static self COMPLETED()
 * @method static self REFUNDED()
 * @method static self CANCELED()
 */
final class ProviderPaymentStatus extends Enum
{
    private const CREATED = 0;
    private const AUTHORIZATION = 1;
    private const COMPLETED = 2;
    private const REFUNDED = 3;
    private const CANCELED = 4;
}
