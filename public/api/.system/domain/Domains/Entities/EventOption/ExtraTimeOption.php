<?php

namespace Domain\Domains\Entities\EventOption;

use Domain\Domains\Entities\EventOption\Utils\QuantityInput;
use Domain\Domains\Entities\EventOption\Utils\QuantityOptionInterface;
use Domain\Domains\ValueObject\EventOption\OptionCategory;
use Domain\Domains\ValueObject\EventOption\OptionKey;

class ExtraTimeOption extends EventOption implements QuantityOptionInterface
{
    use QuantityInput;

    protected string $name = '演奏時間延長オプション';
    protected string $description = '演奏時間を延長できるオプションです。';

    protected function makeOptionKey(array $inputMeta): OptionKey
    {
        return OptionKey::EXTRA_TIME();
    }

    protected function makeOptionCategory(array $inputMeta): OptionCategory
    {
        return OptionCategory::EXTRA_TIME();
    }
}
