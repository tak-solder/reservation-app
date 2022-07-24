<?php

namespace Domain\Domains\Entities\Event;

use Carbon\CarbonImmutable;
use Domain\Domains\Entities\EntityInterface;
use Domain\Domains\Entities\Event\Location\EventLocation;
use Domain\Domains\Entities\EventOption\EventOption;
use Domain\Domains\ValueObject\Event\ApplicationStatus;
use Domain\Domains\ValueObject\Event\EventStatus;
use Domain\Exceptions\InconsistencyException;
use Domain\Exceptions\InvalidValueException;
use Illuminate\Support\Collection;

class Event implements EntityInterface
{
    private int $id;
    private string $title;
    private string $description;
    private CarbonImmutable $startDate;
    private CarbonImmutable $endDate;
    private EventLocation $location;
    private EventStatus $status;
    private int $capacity;
    private int $remain;
    private int $cost;
    private int $revision;
    private ?Collection $options;
    private ?ApplicationStatus $applicationStatus;

    public function __construct(
        int $id,
        string $title,
        string $description,
        CarbonImmutable $startDate,
        CarbonImmutable $endDate,
        EventLocation $location,
        EventStatus $status,
        int $capacity,
        int $remain,
        int $cost,
        int $revision,
        ?Collection $options = null,
        ?ApplicationStatus $applicationStatus = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->location = $location;
        $this->status = $status;
        $this->capacity = $capacity;
        $this->remain = $remain;
        $this->cost = $cost;
        $this->revision = $revision;
        $this->options = $options;
        $this->applicationStatus = $applicationStatus;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStartDate(): CarbonImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): CarbonImmutable
    {
        return $this->endDate;
    }

    public function getLocation(): EventLocation
    {
        return $this->location;
    }

    public function getStatus(): EventStatus
    {
        return $this->status;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getRemain(): int
    {
        return $this->remain;
    }

    /**
     * @param int $remain
     * @return void
     * @throws InvalidValueException
     */
    public function setRemain(int $remain): void
    {
        if ($remain < 0) {
            throw new InvalidValueException($this, 'remain', $remain);
        }
        $this->remain = $remain;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function getRevision(): int
    {
        return $this->revision;
    }

    /**
     * @param int $revision
     * @return void
     * @throws InconsistencyException
     */
    public function setRevision(int $revision): void
    {
        if ($revision - 1 !== $this->revision) {
            throw new InconsistencyException("予約状況に変更がありました");
        }
        $this->revision = $revision;
    }

    /**
     * @return Collection|EventOption[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function setOptions(Collection $options): void
    {
        $this->options = $options;
    }

    public function setApplicationStatus(?ApplicationStatus $status): void
    {
        $this->applicationStatus = $status;
    }

    public function getApplicationStatus(): ?ApplicationStatus
    {
        return $this->applicationStatus;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'startDate' => $this->startDate->format('c'),
            'endDate' => $this->endDate->format('c'),
            'location' => $this->location->toArray(),
            'status' => $this->status->getValue(),
            'capacity' => $this->capacity,
            'remain' => $this->remain,
            'cost' => $this->cost,
            'options' => $this->options->toArray(),
            'applicationStatus' => $this->applicationStatus ? $this->applicationStatus->getValue() : null,
        ];
    }
}
