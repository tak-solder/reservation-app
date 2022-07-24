<?php

namespace Domain\UseCases\Inputs\Reservation;

use Domain\UseCases\Inputs\ValidatesInput;
use Domain\UseCases\Inputs\WithAuthenticatedUser;

class ConfirmCancelValidatesInput extends ValidatesInput
{
    use WithAuthenticatedUser;

    public function getReservationId(): int
    {
        return intval($this->inputs['reservationId']);
    }

    protected function rules(): array
    {
        return [
            'reservationId' => 'required|int'
        ];
    }
}
