<?php

namespace Domain\Domains\ValueObject\Event;

use MyCLabs\Enum\Enum;

/**
 * @method static self REAL()
 * @method static self ONLINE()
 */
final class LocationType extends Enum
{
    private const REAL = 1;
    private const ONLINE = 2;
}
