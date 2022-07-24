<?php

namespace Domain\Domains\Entities\Event;

use Carbon\CarbonImmutable;
use Domain\Domains\ValueObject\Event\EventStatus;
use Illuminate\Support\Collection;

interface EventRepositoryInterface
{
    public function findById(int $id, ?int $userId = null): ?Event;

    /**
     * @param CarbonImmutable|null $fromDate
     * @param CarbonImmutable|null $toDate
     * @param EventStatus|null $status
     * @return Collection|Event[]
     */
    public function getEvents(
        ?CarbonImmutable $fromDate,
        ?CarbonImmutable $toDate,
        ?EventStatus $status,
        ?int $userId = null
    ): Collection;

    public function updateReservationStatus(Event $event): void;
}
