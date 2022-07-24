<?php

namespace Tests\Unit\Domain\Domains\DomainService\Payment;

use Domain\Domains\DomainService\Payment\PaymentItemService;
use Domain\Domains\Entities\Payment\Item\PaymentItem;
use Domain\Domains\ValueObject\Payment\Item\PaymentItemType;
use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Domain\Exceptions\NotFoundEntityException;
use Tests\TestCase;

class PaymentItemServiceTest extends TestCase
{
    private PaymentItemService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(PaymentItemService::class);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findItem_存在するアイテム・金額のデータの取得(): void
    {
        $provider = PaymentProvider::STRIPE();
        $itemType = PaymentItemType::ENTRY();
        $item = $this->service->findItem($provider, $itemType, 1650);
        $this->assertInstanceOf(PaymentItem::class, $item);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findPayment_未登録の金額のデータの取得時にNotFoundEntityExceptionが投げられる(): void
    {
        $provider = PaymentProvider::STRIPE();
        $itemType = PaymentItemType::ENTRY();
        $this->expectException(NotFoundEntityException::class);
        $this->service->findItem($provider, $itemType, 16500);
    }
}
