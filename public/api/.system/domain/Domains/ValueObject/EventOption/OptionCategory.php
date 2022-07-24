<?php

namespace Domain\Domains\ValueObject\EventOption;

use MyCLabs\Enum\Enum;

/**
 * @method static self EXTRA_TIME()
 * @method static self ITEM()
 */
final class OptionCategory extends Enum
{
    private const EXTRA_TIME = OptionKey::EXTRA_TIME;
    private const ITEM = 'item';
}
