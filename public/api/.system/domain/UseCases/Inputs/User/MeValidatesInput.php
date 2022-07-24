<?php

namespace Domain\UseCases\Inputs\User;

use Domain\UseCases\Inputs\ValidatesInput;

class MeValidatesInput extends ValidatesInput
{
    public function getToken(): string
    {
        return $this->inputs['token'];
    }

    protected function rules(): array
    {
        return [
            'token' => 'required|string',
        ];
    }
}
