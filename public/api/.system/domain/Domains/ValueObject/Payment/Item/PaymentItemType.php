<?php

namespace Domain\Domains\ValueObject\Payment\Item;

use Domain\Domains\ValueObject\EventOption\OptionKey;
use MyCLabs\Enum\Enum;

/**
 * @method static self ENTRY()
 * @method static self EXTRA_TIME()
 * @method static self MUSIC_STAND()
 * @method static self DUET_CHAIR()
 * @method static self MIC()
 * @method static self MIC_STAND()
 * @method static self VIDEO_DATA()
 */
final class PaymentItemType extends Enum
{
    private const ENTRY = 'entry';
    private const EXTRA_TIME = OptionKey::EXTRA_TIME;
    private const MUSIC_STAND = OptionKey::MUSIC_STAND;
    private const DUET_CHAIR = OptionKey::DUET_CHAIR;
    private const MIC = OptionKey::MIC;
    private const MIC_STAND = OptionKey::MIC_STAND;
    private const VIDEO_DATA = OptionKey::VIDEO_DATA;
}
