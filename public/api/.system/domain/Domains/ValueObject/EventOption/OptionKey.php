<?php

namespace Domain\Domains\ValueObject\EventOption;

use MyCLabs\Enum\Enum;

/**
 * @method static self EXTRA_TIME()
 * @method static self MUSIC_STAND()
 * @method static self DUET_CHAIR()
 * @method static self MIC()
 * @method static self MIC_STAND()
 * @method static self VIDEO_DATA()
 */
final class OptionKey extends Enum
{
    public const EXTRA_TIME = 'extraTime';
    public const MUSIC_STAND = 'musicStand';
    public const DUET_CHAIR = 'duetChair';
    public const MIC = 'mic';
    public const MIC_STAND = 'micStand';
    public const VIDEO_DATA = 'videoData';
}
