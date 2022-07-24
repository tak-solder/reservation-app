<?php

namespace Domain\UseCases\Interactor\Event;

use Domain\Domains\Entities\Event\EventRepositoryInterface;
use Domain\UseCases\Inputs\Event\GetEventValidatesInput;
use Domain\UseCases\Outputs\Event\GetEventOutput;

class GetEventInteractor
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function handle(GetEventValidatesInput $input): GetEventOutput
    {
        $event = $this->eventRepository->findById($input->getId(), $input->getUserId());
        return new GetEventOutput($event);
    }
}
