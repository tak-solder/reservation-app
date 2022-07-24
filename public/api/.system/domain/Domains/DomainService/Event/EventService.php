<?php

namespace Domain\Domains\DomainService\Event;

use Domain\Domains\Entities\Event\Event;
use Domain\Domains\Entities\Event\EventRepositoryInterface;
use Domain\Exceptions\NotFoundEntityException;

class EventService
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(
        EventRepositoryInterface $eventRepository
    ) {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param int $eventId
     * @param int $userId
     * @return Event
     * @throws NotFoundEntityException
     */
    public function findEvent(int $eventId, int $userId): Event
    {
        $event = $this->eventRepository->findById($eventId, $userId);
        if (!$event) {
            throw new NotFoundEntityException(Event::class, compact('eventId'));
        }

        return $event;
    }
}
