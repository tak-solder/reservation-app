<?php

namespace Domain\Domains\Entities\Payment\Provider\Stripe\Checkout;

use Domain\Domains\Entities\EntityInterface;
use Illuminate\Support\Collection;

class CheckoutOrder implements EntityInterface
{
    private int $eventId;

    /**
     * @var Collection|CheckoutLineItem[]
     */
    private Collection $lineItems;

    public function __construct(int $eventId, Collection $lineItems)
    {
        $this->eventId = $eventId;
        $this->lineItems = $lineItems;
    }

    public function toArray()
    {
        return [
            'eventId' => $this->eventId,
            'lineItems' => $this->lineItems->toArray(),
            'amount' => $this->getTotalAmount(),
        ];
    }

    public function getLineItemList(): Collection
    {
        return $this->lineItems->map(fn(CheckoutLineItem $item) => $item->getLineItemData());
    }

    public function getTotalAmount(): int
    {
        return $this->lineItems->sum(fn(CheckoutLineItem $item) => $item->getTotalAmount());
    }
}
