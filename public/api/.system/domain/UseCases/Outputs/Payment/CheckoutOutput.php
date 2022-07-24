<?php

namespace Domain\UseCases\Outputs\Payment;

use Domain\Domains\Entities\Payment\Provider\PaymentDataInterface;
use Domain\UseCases\Outputs\OutputInterface;

class CheckoutOutput implements OutputInterface
{
    private PaymentDataInterface $checkoutData;

    public function __construct(PaymentDataInterface $checkoutData)
    {
        $this->checkoutData = $checkoutData;
    }

    public function toArray()
    {
        return [
            'checkoutData' => $this->getCheckoutData()->toArray(),
        ];
    }

    public function getCheckoutData(): PaymentDataInterface
    {
        return $this->checkoutData;
    }
}
