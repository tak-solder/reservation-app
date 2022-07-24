<?php

namespace Domain\UseCases\Inputs\Reservation;

use Domain\UseCases\Inputs\ValidatesInput;
use Domain\UseCases\Inputs\WithAuthenticatedUser;

class ExecuteCancelValidatesInput extends ValidatesInput
{
    use WithAuthenticatedUser;

    public function getReservationId(): int
    {
        return intval($this->inputs['reservationId']);
    }

    public function getCancelRate(): int
    {
        return intval($this->inputs['cancelRate']);
    }

    protected function rules(): array
    {
        return [
            'reservationId' => 'required|int',
            'cancelRate' => 'required|int',
        ];
    }
}
