<?php

namespace Domain\UseCases\Outputs\Event;

use Domain\UseCases\Outputs\OutputInterface;
use Illuminate\Support\Collection;

class GetEventsOutput implements OutputInterface
{
    private Collection $events;

    public function __construct(Collection $events)
    {
        $this->events = $events;
    }

    public function toArray()
    {
        return [
            'events' => $this->getEvents()->toArray(),
        ];
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }
}
