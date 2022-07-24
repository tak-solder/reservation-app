<?php

namespace Domain\Domains\ValueObject\Reservation;

use MyCLabs\Enum\Enum;

/**
 * @method static self CANCELED()
 * @method static self APPLIED()
 * @method static self FINISHED()
 */
final class ReservationStatus extends Enum
{
    private const CANCELED = 0;
    private const APPLIED = 1;
    private const FINISHED = 2;
}
