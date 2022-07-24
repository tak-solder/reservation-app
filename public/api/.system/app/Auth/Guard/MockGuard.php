<?php

namespace App\Auth\Guard;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;

class MockGuard implements Guard
{
    private ?Authenticatable $user = null;

    public function check()
    {
        return !$this->guest();
    }

    public function guest()
    {
        return is_null($this->user());
    }

    public function user()
    {
        return $this->user;
    }

    public function id()
    {
        return $this->user->getAuthIdentifier();
    }

    public function validate(array $credentials = [])
    {
        return false;
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }
}
