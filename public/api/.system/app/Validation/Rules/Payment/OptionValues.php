<?php

namespace App\Validation\Rules\Payment;

use Domain\Domains\ValueObject\EventOption\OptionKey;
use Illuminate\Contracts\Validation\Rule;

class OptionValues implements Rule
{
    /**
     * @param string $attribute
     * @param array $optionValues
     * @return bool
     */
    public function passes($attribute, $optionValues)
    {
        foreach ($optionValues as $key => $value) {
            switch ($key) {
                case OptionKey::EXTRA_TIME()->getValue():
                    $result = $this->validateExtraTime($value);
                    break;

                case OptionKey::MUSIC_STAND()->getValue():
                case OptionKey::DUET_CHAIR()->getValue():
                case OptionKey::MIC()->getValue():
                case OptionKey::MIC_STAND()->getValue():
                case OptionKey::VIDEO_DATA()->getValue():
                    $result = $this->validateItemOption($value);
                    break;

                default:
                    $result = true;
                    logger()->info("unexpected option: {$key}={$value}");
            }

            if (!$result) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return string
     */
    public function message()
    {
        return '無効なオプションが選択されました。';
    }

    /**
     * @param string $value
     * @return bool
     */
    private function validateExtraTime($value): bool
    {
        $intValue = filter_var($value, FILTER_VALIDATE_INT);
        return $intValue !== false && $intValue >= 0 && $intValue <= 2;
    }

    /**
     * @param bool $value
     * @return bool
     */
    private function validateItemOption($value): bool
    {
        return is_bool($value);
    }
}
