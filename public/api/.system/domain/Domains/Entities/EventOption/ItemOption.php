<?php

namespace Domain\Domains\Entities\EventOption;

use Domain\Domains\Entities\EventOption\Utils\QuantityInput;
use Domain\Domains\Entities\EventOption\Utils\QuantityOptionInterface;
use Domain\Domains\ValueObject\EventOption\OptionCategory;
use Domain\Domains\ValueObject\EventOption\OptionKey;
use Domain\Exceptions\InvalidValueException;

class ItemOption extends EventOption implements QuantityOptionInterface
{
    use QuantityInput;

    private const ITEMS = [
        OptionKey::MUSIC_STAND => [
            'key' => OptionKey::MUSIC_STAND,
            'name' => '譜面台',
            'description' => 'テキストテキスト',
        ],
        OptionKey::DUET_CHAIR => [
            'key' => OptionKey::DUET_CHAIR,
            'name' => '連弾用ピアノ椅子',
            'description' => 'テキストテキスト',
        ],
        OptionKey::MIC => [
            'key' => OptionKey::MIC,
            'name' => 'マイク',
            'description' => 'テキストテキスト',
        ],
        OptionKey::MIC_STAND => [
            'key' => OptionKey::MIC_STAND,
            'name' => 'マイクスタンド',
            'description' => 'テキストテキスト',
        ],
        OptionKey::VIDEO_DATA => [
            'key' => OptionKey::VIDEO_DATA,
            'name' => '演奏動画データ',
            'description' => 'テキストテキスト',
        ],
    ];
    protected function makeOptionKey(array $inputMeta): OptionKey
    {
        $key = $inputMeta['key'] ?? null;
        if (!isset(self::ITEMS[$key])) {
            throw new InvalidValueException($this, 'meta.key', $key ?? 'empty');
        }

        $item = self::ITEMS[$key];
        $this->name = $item['name'];
        $this->description = $item['description'];

        return OptionKey::from($key);
    }

    protected function makeOptionCategory(array $inputMeta): OptionCategory
    {
        return OptionCategory::ITEM();
    }
}
