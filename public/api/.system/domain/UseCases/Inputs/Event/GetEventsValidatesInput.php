<?php

namespace Domain\UseCases\Inputs\Event;

use Carbon\CarbonImmutable;
use Domain\UseCases\Inputs\ValidatesInput;
use Domain\UseCases\Inputs\WithAuthenticatedUser;

class GetEventsValidatesInput extends ValidatesInput
{
    use WithAuthenticatedUser;

    public function getFromDate(): ?CarbonImmutable
    {
        return isset($this->inputs['fromDate']) ? CarbonImmutable::parse($this->inputs['fromDate']) : null;
    }

    public function getToDate(): ?CarbonImmutable
    {
        return isset($this->inputs['toDate']) ? CarbonImmutable::parse($this->inputs['toDate']) : null;
    }

    protected function rules(): array
    {
        return [
            'fromDate' => 'date',
            'toDate' => 'date',
        ];
    }
}
