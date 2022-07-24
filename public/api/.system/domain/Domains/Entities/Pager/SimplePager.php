<?php

namespace Domain\Domains\Entities\Pager;

use Domain\Domains\Entities\EntityInterface;

class SimplePager implements EntityInterface
{
    private int $current;
    private bool $hasMore;

    public function __construct(int $current, bool $hasMore)
    {
        $this->current = $current;
        $this->hasMore = $hasMore;
    }

    public function toArray()
    {
        return [
            'current' => $this->current,
            'hasMore' => $this->hasMore,
        ];
    }
}
