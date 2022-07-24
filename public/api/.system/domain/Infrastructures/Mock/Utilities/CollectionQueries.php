<?php

namespace Domain\Infrastructures\Mock\Utilities;

use Domain\Domains\Entities\EntityInterface;
use Domain\Exceptions\NotFoundEntityException;
use Illuminate\Support\Collection;

/**
 * @template T
 */
trait CollectionQueries
{
    protected Collection $collection;

    /**
     * @param \Closure $closure
     * @return T|null
     */
    private function find(\Closure $closure)
    {
        return $this->collection->first($closure);
    }

    private function filter(\Closure $closure, string $sortKey = null, bool $desc = false): Collection
    {
        $collection = $this->collection->filter($closure);
        if ($sortKey) {
            $collection = $collection->sortBy(function (EntityInterface $entity) use ($sortKey) {
                return data_get($entity->toArray(), $sortKey) ?? null;
            }, SORT_REGULAR, $desc);
        }

        return $collection->values();
    }

    private function getMaxId(): int
    {
        return $this->collection->max(fn($entity) => $entity->getId());
    }

    private function replaceEntity(int $id, EntityInterface $entity): void
    {
        /** @var int|false $index */
        $index = $this->collection->search(fn($entity) => $entity->getId() === $id);
        if ($index === false) {
            throw new NotFoundEntityException(get_class($this), compact('id'));
        }

        $this->collection->splice($index, 1, [$entity]);
    }

    protected function persistence(): void
    {
    }

    protected function load(): bool
    {
        return false;
    }
}
