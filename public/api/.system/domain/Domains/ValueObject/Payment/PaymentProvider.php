<?php

namespace Domain\Domains\ValueObject\Payment;

use MyCLabs\Enum\Enum;

/**
 * @method static self STRIPE()
 * @method static self PAYPAY()
 */
final class PaymentProvider extends Enum
{
    private const STRIPE = 1;
    private const PAYPAY = 2;
}
