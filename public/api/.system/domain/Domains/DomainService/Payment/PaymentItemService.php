<?php

namespace Domain\Domains\DomainService\Payment;

use Domain\Domains\Entities\Payment\Item\PaymentItem;
use Domain\Domains\Entities\Payment\Item\PaymentItemRepositoryInterface;
use Domain\Domains\ValueObject\Payment\Item\PaymentItemType;
use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Domain\Exceptions\NotFoundEntityException;

class PaymentItemService
{
    private PaymentItemRepositoryInterface $itemRepository;

    public function __construct(
        PaymentItemRepositoryInterface $itemRepository
    ) {
        $this->itemRepository = $itemRepository;
    }

    public function findItem(PaymentProvider $provider, PaymentItemType $itemType, int $amount): PaymentItem
    {
        $item = $this->itemRepository->findByItem($provider, $itemType, $amount);
        if (!$item) {
            throw new NotFoundEntityException(PaymentItem::class, [
                'provider' => $provider,
                'itemType' => $itemType,
                'amount' => $amount,
            ]);
        }

        return $item;
    }
}
