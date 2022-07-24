<?php

namespace Domain\Domains\ValueObject\Event;

use MyCLabs\Enum\Enum;

/**
 * @method static self UNAVAILABLE()
 * @method static self AVAILABLE()
 * @method static self APPLIED()
 * @method static self WAITING()
 */
final class ApplicationStatus extends Enum
{
    private const UNAVAILABLE = 0;
    private const AVAILABLE = 1;
    private const APPLIED = 2;
    private const WAITING = 3;
}
