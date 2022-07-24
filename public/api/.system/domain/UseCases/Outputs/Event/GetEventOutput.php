<?php

namespace Domain\UseCases\Outputs\Event;

use Domain\Domains\Entities\Event\Event;
use Domain\UseCases\Outputs\OutputInterface;

class GetEventOutput implements OutputInterface
{
    private ?Event $event;

    public function __construct(?Event $event)
    {
        $this->event = $event;
    }

    public function toArray()
    {
        return [
            'event' => $this->getEvent() ? $this->getEvent()->toArray() : null,
        ];
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }
}
