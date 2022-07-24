<?php

namespace Domain\UseCases\Outputs\Reservation;

use Domain\Domains\Entities\Reservation\Cancel\CancelQuotation;
use Domain\UseCases\Outputs\OutputInterface;

class ExecuteCancelOutput implements OutputInterface
{
    private CancelQuotation $cancelQuotation;

    public function __construct(CancelQuotation $cancelQuotation)
    {
        $this->cancelQuotation = $cancelQuotation;
    }

    public function toArray()
    {
        return $this->cancelQuotation->toArray();
    }
}
