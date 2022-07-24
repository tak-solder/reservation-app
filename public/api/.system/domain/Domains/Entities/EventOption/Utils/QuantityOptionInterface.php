<?php

namespace Domain\Domains\Entities\EventOption\Utils;

interface QuantityOptionInterface
{
    public function getQuantity(): int;

    public function setQuantity(int $quantity): void;
}
