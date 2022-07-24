<?php

namespace Domain\Infrastructures\Mock\Repositories;

use Domain\Domains\Entities\User\User;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Domain\Infrastructures\Mock\Utilities\CollectionQueries;
use Illuminate\Support\Collection;

class MockUserRepository implements UserRepositoryInterface
{
    use CollectionQueries;

    public function __construct()
    {
        $this->collection = new Collection([
            new User(1, "User 1", "user1"),
            new User(2, "User 2", "user2"),
        ]);
    }

    public function findById(int $id): ?User
    {
        return $this->find(fn(User $user) => $user->getId() === $id);
    }

    public function findByLineId(string $lineId): ?User
    {
        return $this->find(fn(User $user) => $user->getLineId() === $lineId);
    }
}
