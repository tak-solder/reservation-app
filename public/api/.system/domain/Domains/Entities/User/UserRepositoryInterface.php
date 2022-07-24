<?php

namespace Domain\Domains\Entities\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByLineId(string $lineId): ?User;
}
