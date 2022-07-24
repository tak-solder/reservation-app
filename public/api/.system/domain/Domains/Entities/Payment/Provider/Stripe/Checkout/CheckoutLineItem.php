<?php

namespace Domain\Domains\Entities\Payment\Provider\Stripe\Checkout;

use Domain\Domains\Entities\EntityInterface;

class CheckoutLineItem implements EntityInterface
{
    private int $paymentItemId;
    private string $price;
    private int $amount;
    private int $quantity;

    public function __construct(int $paymentItemId, string $priceId, int $amount, int $quantity)
    {
        $this->paymentItemId = $paymentItemId;
        $this->price = $priceId;
        $this->amount = $amount;
        $this->quantity = $quantity;
    }

    public function getTotalAmount(): int
    {
        return $this->amount * $this->quantity;
    }

    public function toArray()
    {
        return [
            'paymentItemId' => $this->paymentItemId,
            'price' => $this->price,
            'amount' => $this->amount,
            'quantity' => $this->quantity,
        ];
    }

    public function getLineItemData(): array
    {
        return [
            'price' => $this->price,
            'quantity' => $this->quantity,
        ];
    }
}
