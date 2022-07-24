<?php

namespace Domain\Domains\ValueObject\Event;

use MyCLabs\Enum\Enum;

/**
 * @method static self CANCELED()
 * @method static self SCHEDULED()
 * @method static self FINISHED()
 * @method static self SUSPENDED()
 */
final class EventStatus extends Enum
{
    private const CANCELED = 0;
    private const SCHEDULED = 1;
    private const FINISHED = 2;
    private const SUSPENDED = 3;
}
