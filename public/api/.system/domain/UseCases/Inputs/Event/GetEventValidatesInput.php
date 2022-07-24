<?php

namespace Domain\UseCases\Inputs\Event;

use Domain\UseCases\Inputs\ValidatesInput;
use Domain\UseCases\Inputs\WithAuthenticatedUser;

class GetEventValidatesInput extends ValidatesInput
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
