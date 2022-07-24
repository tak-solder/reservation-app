<?php

namespace Domain\Domains\Entities\Payment\Item;

use Domain\Domains\Entities\EntityInterface;
use Domain\Domains\ValueObject\Payment\Item\PaymentItemType;
use Domain\Domains\ValueObject\Payment\PaymentProvider;

class PaymentItem implements EntityInterface
{
    private int $id;
    private PaymentProvider $provider;
    private PaymentItemType $itemType;
    private int $amount;
    private string $providerId;
    /**
     * @var array
     */
    private array $itemData;

    /**
     * @param int $id
     * @param PaymentProvider $provider
     * @param PaymentItemType $itemType
     * @param int $amount
     * @param string $providerId
     * @param array $itemData
     */
    public function __construct(
        int $id,
        PaymentProvider $provider,
        PaymentItemType $itemType,
        int $amount,
        string $providerId,
        array $itemData
    ) {
        $this->id = $id;
        $this->provider = $provider;
        $this->itemType = $itemType;
        $this->amount = $amount;
        $this->providerId = $providerId;
        $this->itemData = $itemData;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProvider(): PaymentProvider
    {
        return $this->provider;
    }

    public function getItemType(): PaymentItemType
    {
        return $this->itemType;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getProviderId(): string
    {
        return $this->providerId;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'provider' => $this->provider->getValue(),
            'itemType' => $this->itemType->getValue(),
            'amount' => $this->amount,
            'providerId' => $this->providerId,
            'itemData' => $this->itemData,
        ];
    }
}
