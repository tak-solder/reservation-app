<?php

namespace Domain\Domains\Entities\Payment\History;

use Carbon\CarbonImmutable;
use Domain\Domains\Entities\EntityInterface;
use Domain\Domains\ValueObject\Payment\PaymentStatus;

class UpdateHistory implements EntityInterface
{
    private PaymentStatus $status;
    private CarbonImmutable $updatedAt;
    private string $remarks;

    public function __construct(
        PaymentStatus $status,
        CarbonImmutable $updatedAt,
        string $remarks = ''
    ) {
        $this->status = $status;
        $this->updatedAt = $updatedAt;
        $this->remarks = $remarks;
    }

    public function toArray()
    {
        return [
            'status' => $this->status->getValue(),
            'updatedAt' => $this->updatedAt->format('c'),
            'remarks' => $this->remarks,
        ];
    }
}
