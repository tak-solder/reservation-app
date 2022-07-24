<?php

namespace Domain\UseCases\Inputs\Reservation;

use Domain\Domains\ValueObject\Reservation\ReservationStatus;
use Domain\UseCases\Inputs\ValidatesInput;
use Domain\UseCases\Inputs\WithAuthenticatedUser;

class GetReservationsValidatesInput extends ValidatesInput
{
    use WithAuthenticatedUser;

    public function getStatus(): ?ReservationStatus
    {
        return isset($this->inputs['status']) ? ReservationStatus::from(intval($this->inputs['status'])) : null;
    }

    public function getPage(): int
    {
        return filter_var($this->inputs['page'] ?? 1, FILTER_VALIDATE_INT) ?: 1;
    }

    protected function rules(): array
    {
        return [
            'status' => 'int',
            'page' => 'int|min:1',
        ];
    }
}
