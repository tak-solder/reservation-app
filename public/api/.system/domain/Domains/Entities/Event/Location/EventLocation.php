<?php

namespace Domain\Domains\Entities\Event\Location;

use Domain\Domains\Entities\EntityInterface;
use Domain\Domains\ValueObject\Event\LocationType;
use Domain\Domains\ValueObject\Reservation\ReservationStatus;

class EventLocation implements EntityInterface
{
    private LocationType $locationType;
    private string $name;
    private string $summary;
    private bool $isPrivate;
    private ?string $publicAddress;
    private ?string $privateAddress;
    private ?string $url;

    private ?ReservationStatus $reservationStatus = null;

    public function __construct(
        LocationType $locationType,
        string $name,
        string $summary,
        bool $isPrivate,
        ?string $publicAddress,
        ?string $privateAddress,
        ?string $url
    ) {
        $this->locationType = $locationType;
        $this->name = $name;
        $this->summary = $summary;
        $this->isPrivate = $isPrivate;
        $this->publicAddress = $publicAddress;
        $this->privateAddress = $privateAddress;
        $this->url = $url;
    }

    public function setReservationStatus(ReservationStatus $status): void
    {
        $this->reservationStatus = $status;
    }

    public function getAddress(): ?string
    {
        if (!$this->reservationStatus) {
            return $this->publicAddress;
        }
        if (!$this->privateAddress) {
            return $this->publicAddress;
        }

        if (!$this->reservationStatus->equals(ReservationStatus::APPLIED())) {
            return $this->publicAddress;
        }

        return $this->privateAddress;
    }

    public function toArray()
    {
        return [
            'locationType' => $this->locationType->getValue(),
            'name' => $this->name,
            'summary' => $this->summary,
            'isPrivate' => $this->isPrivate,
            'address' => $this->getAddress(),
            'url' => $this->url,
        ];
    }
}
