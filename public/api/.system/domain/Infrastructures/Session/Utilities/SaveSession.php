<?php

namespace Domain\Infrastructures\Session\Utilities;

use Illuminate\Support\Collection;

/**
 * @mixin \Domain\Infrastructures\Mock\Utilities\CollectionQueries
 */
trait SaveSession
{
    private function sessionkey(): string
    {
        $className = get_class($this);
        return "mockRepository::{$className}";
    }

    protected function persistence(): void
    {
        $request = request();
        if ($request->hasSession()) {
            $request->session()->put($this->sessionkey(), serialize($this->collection));
        }
    }

    protected function load(): bool
    {
        $request = request();
        if (!$request->hasSession()) {
            return false;
        }

        $sessionData = $request->session()->get($this->sessionkey());
        $collection = $sessionData ? unserialize($sessionData) : null;
        if ($collection instanceof Collection) {
            $this->collection = $collection;
            return true;
        }

        return false;
    }
}
