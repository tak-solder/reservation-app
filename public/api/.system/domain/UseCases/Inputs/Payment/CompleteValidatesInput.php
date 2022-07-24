<?php

namespace Domain\UseCases\Inputs\Payment;

use Domain\UseCases\Inputs\ValidatesInput;
use Domain\UseCases\Inputs\WithAuthenticatedUser;

class CompleteValidatesInput extends ValidatesInput
{
    use WithAuthenticatedUser;

    protected function rules(): array
    {
        return [
            'paymentId' => ['required', 'int',]
        ];
    }

    public function getPaymentId(): int
    {
        return intval($this->inputs['paymentId']);
    }
}
