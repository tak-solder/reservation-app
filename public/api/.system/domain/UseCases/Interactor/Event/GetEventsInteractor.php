<?php

namespace Domain\UseCases\Interactor\Event;

use Domain\Domains\Entities\Event\EventRepositoryInterface;
use Domain\UseCases\Inputs\Event\GetEventsValidatesInput;
use Domain\UseCases\Outputs\Event\GetEventsOutput;

class GetEventsInteractor
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function handle(GetEventsValidatesInput $input): GetEventsOutput
    {
        $collection = $this->eventRepository->getEvents(
            $input->getFromDate(),
            $input->getToDate(),
            null,
            $input->getUserId()
        );

        return new GetEventsOutput($collection);
    }
}
