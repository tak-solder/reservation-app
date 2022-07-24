<?php

namespace Domain\Domains\Entities\EventOption;

use Domain\Domains\Entities\EntityInterface;
use Domain\Domains\ValueObject\EventOption\OptionCategory;
use Domain\Domains\ValueObject\EventOption\OptionInputType;
use Domain\Domains\ValueObject\EventOption\OptionKey;

abstract class EventOption implements EntityInterface
{
    public const OPTION_KEY = '';

    protected OptionKey $key;
    protected OptionCategory $category;
    protected string $name;
    protected string $description;
    private OptionInputType $inputType;
    protected array $meta;

    abstract protected function makeOptionKey(array $inputMeta): OptionKey;
    abstract protected function makeOptionCategory(array $inputMeta): OptionCategory;
    abstract protected function makeInputType(array $inputMeta): OptionInputType;

    /**
     * @param array $meta
     * @return void
     */
    abstract protected function validateMeta(array $meta): void;

    abstract public function getCost(?string $value = null): int;

    /**
     * @param array $meta
     */
    public function __construct(array $meta)
    {
        $this->key = $this->makeOptionKey($meta);
        $this->category = $this->makeOptionCategory($meta);
        $this->inputType = $this->makeInputType($meta);
        $this->meta = $this->initMeta($meta);
    }

    /**
     * @param array $meta
     * @return array
     */
    protected function initMeta(array $meta): array
    {
        $this->validateMeta($meta);
        return $meta;
    }

    public function getOptionKey(): OptionKey
    {
        return $this->key;
    }

    public function getKey(): string
    {
        return $this->getOptionKey()->getValue();
    }

    public function getCategory(): OptionCategory
    {
        return $this->category;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getInputType(): OptionInputType
    {
        return $this->inputType;
    }

    /**
     * @return array
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    public function toArray()
    {
        return [
            'key' => $this->getKey(),
            'category' => $this->getCategory()->getValue(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'inputType' => $this->getInputType()->getValue(),
            'meta' => $this->getMeta(),
        ];
    }
}
