<?php

namespace Domain\UseCases\Outputs\Payment;

use Domain\Domains\Entities\Payment\Payment;
use Domain\UseCases\Outputs\OutputInterface;

class CallbackOutput implements OutputInterface
{
    private Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function toArray()
    {
        return [
            'payment' => $this->getPayment()->toArray(),
        ];
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }
}
