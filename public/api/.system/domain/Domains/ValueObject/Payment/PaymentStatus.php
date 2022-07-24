<?php

namespace Domain\Domains\ValueObject\Payment;

use MyCLabs\Enum\Enum;

/**
 * @method static self CREATED()
 * @method static self CANCELED()
 * @method static self REQUESTED()
 * @method static self COMPLETED()
 * @method static self REFUNDED()
 */
final class PaymentStatus extends Enum
{
    private const CREATED = 0;
    private const REQUESTED = 1;
    private const COMPLETED = 2;
    private const REFUNDED = 3;
    private const CANCELED = 4;
}
