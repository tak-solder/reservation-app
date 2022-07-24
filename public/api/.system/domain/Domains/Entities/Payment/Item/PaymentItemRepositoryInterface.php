<?php

namespace Domain\Domains\Entities\Payment\Item;

use Domain\Domains\ValueObject\Payment\Item\PaymentItemType;
use Domain\Domains\ValueObject\Payment\PaymentProvider;

interface PaymentItemRepositoryInterface
{
    public function findByItem(
        PaymentProvider $provider,
        PaymentItemType $itemType,
        int $amount
    ): ?PaymentItem;

    public function findByItemId(
        PaymentProvider $provider,
        string $itemId
    ): ?PaymentItem;

    /**
     * @param PaymentProvider $provider
     * @param PaymentItemType $itemType
     * @param int $amount
     * @param string $itemId
     * @param array $itemData
     * @return PaymentItem
     */
    public function createItem(PaymentProvider $provider, PaymentItemType $itemType, int $amount, string $itemId, array $itemData): PaymentItem;
}
