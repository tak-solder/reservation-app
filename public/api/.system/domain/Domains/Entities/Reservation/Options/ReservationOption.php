<?php

namespace Domain\Domains\Entities\Reservation\Options;

use Domain\Domains\Entities\EntityInterface;

class ReservationOption implements EntityInterface
{
    private string $key;
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $key
     * @param mixed $value
     */
    public function __construct(string $key, $value)
    {
        $this->setKey($key);
        $this->setValue($value);
    }

    protected function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function toArray()
    {
        return [
            'key' => $this->getKey(),
            'value' => $this->getValue(),
        ];
    }
}
