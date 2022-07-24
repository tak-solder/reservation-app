<?php

namespace Domain\Infrastructures\Mock\Repositories;

use Domain\Domains\Entities\Payment\Item\PaymentItem;
use Domain\Domains\Entities\Payment\Item\PaymentItemRepositoryInterface;
use Domain\Domains\ValueObject\Payment\Item\PaymentItemType;
use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Domain\Infrastructures\Mock\Utilities\CollectionQueries;
use Illuminate\Support\Collection;

class MockPaymentItemRepository implements PaymentItemRepositoryInterface
{
    use CollectionQueries;

    public function __construct()
    {
        if ($this->load()) {
            return;
        }

        $this->collection = new Collection([
            new PaymentItem(
                1,
                PaymentProvider::STRIPE(),
                PaymentItemType::ENTRY(),
                1650,
                'price_1LM7G6GPzAfH8QKtxK0LwOtZ',
                ['test' => 'hogehoge',]
            ),
            new PaymentItem(
                2,
                PaymentProvider::STRIPE(),
                PaymentItemType::ENTRY(),
                5500,
                'price_1LM7H8GPzAfH8QKtVEPSw16Y',
                ['test' => 'hogehoge',]
            ),
            new PaymentItem(
                3,
                PaymentProvider::STRIPE(),
                PaymentItemType::EXTRA_TIME(),
                825,
                'price_1LM7CjGPzAfH8QKttSb9C9rQ',
                ['test' => 'hogehoge',]
            ),
            new PaymentItem(
                3,
                PaymentProvider::STRIPE(),
                PaymentItemType::MUSIC_STAND(),
                110,
                'price_1LM73OGPzAfH8QKt1XwPxl67',
                ['test' => 'hogehoge',]
            ),
            new PaymentItem(
                3,
                PaymentProvider::STRIPE(),
                PaymentItemType::DUET_CHAIR(),
                110,
                'price_1LM73kGPzAfH8QKtNhXau06a',
                ['test' => 'hogehoge',]
            ),
            new PaymentItem(
                3,
                PaymentProvider::STRIPE(),
                PaymentItemType::MIC(),
                110,
                'price_1LM73xGPzAfH8QKtcn2OjfuR',
                ['test' => 'hogehoge',]
            ),
            new PaymentItem(
                3,
                PaymentProvider::STRIPE(),
                PaymentItemType::MIC_STAND(),
                110,
                'price_1LM74AGPzAfH8QKt7Kikzecc',
                ['test' => 'hogehoge',]
            ),
            new PaymentItem(
                3,
                PaymentProvider::STRIPE(),
                PaymentItemType::VIDEO_DATA(),
                110,
                'price_1LM74QGPzAfH8QKt5pHAX32X',
                ['test' => 'hogehoge',]
            ),
        ]);
    }

    public function findByItem(PaymentProvider $provider, PaymentItemType $itemType, int $amount): ?PaymentItem
    {
        return $this->find(fn(PaymentItem $item) => $item->getProvider()->equals($provider) && $item->getItemType()->equals($itemType) && $item->getAmount() === $amount);
    }

    public function findByItemId(PaymentProvider $provider, string $itemId): ?PaymentItem
    {
        return $this->find(fn(PaymentItem $item) => $item->getProvider()->equals($provider) && $item->getProviderId() === $itemId);
    }

    public function createItem(PaymentProvider $provider, PaymentItemType $itemType, int $amount, string $itemId, array $itemData): PaymentItem
    {
        $paymentItem = new PaymentItem(
            $this->collection->last()->getId() + 1,
            $provider,
            $itemType,
            $amount,
            $itemId,
            $itemData
        );
        $this->collection->push($paymentItem);
        $this->persistence();

        return $paymentItem;
    }
}
