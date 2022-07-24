<?php

namespace Domain\UseCases\Inputs;

use Domain\Domains\Entities\User\User;

trait WithAuthenticatedUser
{
    private User $user;

    /**
     * @param User|\Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function setAuthenticatedUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): int
    {
        return $this->user->getId();
    }
}
