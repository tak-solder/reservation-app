<?php

namespace Domain\UseCases\Inputs\Reservation;

use Domain\UseCases\Inputs\ValidatesInput;
use Domain\UseCases\Inputs\WithAuthenticatedUser;

class GetReservationValidatesInput extends ValidatesInput
{
    use WithAuthenticatedUser;

    public function getId(): int
    {
        return intval($this->inputs['id']);
    }

    protected function rules(): array
    {
        return [
            'id' => 'required|int'
        ];
    }
}
