<?php

namespace Domain\Domains\Entities\EventOption\Utils;

use Domain\Domains\Entities\EventOption\EventOption;
use Domain\Domains\ValueObject\EventOption\OptionInputType;
use Domain\Exceptions\InvalidValueException;

/**
 * @mixin EventOption
 */
trait QuantityInput
{
    public function getCost(?string $value = null): int
    {
        return $this->getMeta()['cost'] ?? 0;
    }

    public function getQuantity(): int
    {
        return $this->getMeta()['quantity'];
    }

    /**
     * @param int $quantity
     * @return void
     * @throws InvalidValueException
     */
    public function setQuantity(int $quantity): void
    {
        if ($quantity < 0) {
            throw new InvalidValueException($this, 'quantity', $quantity);
        }
        $this->meta['quantity'] = $quantity;
    }

    protected function makeInputType(array $inputMeta): OptionInputType
    {
        return OptionInputType::QUANTITY();
    }

    /**
     * @param array<string, mixed> $meta
     * @return void
     */
    protected function validateMeta(array $meta): void
    {
        if (isset($meta['cost']) && filter_var($meta['cost'], FILTER_VALIDATE_INT) === false) {
            throw new \UnexpectedValueException('meta.cost is excepted int');
        }

        if (!isset($meta['quantity']) || filter_var($meta['quantity'], FILTER_VALIDATE_INT) === false) {
            throw new \UnexpectedValueException('meta.quantity is excepted int and required');
        }
    }
}
