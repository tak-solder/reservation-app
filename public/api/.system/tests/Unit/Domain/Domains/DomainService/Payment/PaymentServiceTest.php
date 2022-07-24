<?php

namespace Tests\Unit\Domain\Domains\DomainService\Payment;

use Domain\Domains\DomainService\Payment\PaymentService;
use Domain\Domains\DomainService\Payment\Provider\PaymentProviderServiceInterface;
use Domain\Domains\DomainService\Payment\Provider\StripeProviderService;
use Domain\Domains\Entities\Payment\Payment;
use Domain\Domains\Entities\User\User;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Domain\Exceptions\NotFoundEntityException;
use Domain\Exceptions\UnexpectedValueObjectException;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    private PaymentService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(PaymentService::class);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findPayment_存在する決済の取得(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);
        $payment = $this->service->findPayment($user, 1);
        $this->assertInstanceOf(Payment::class, $payment);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findPayment_存在しないの決済の取得時にNotFoundEntityExceptionが投げられる(): void
    {
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);
        $this->expectException(NotFoundEntityException::class);
        $this->service->findPayment($user, 100);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findPayment_異なるユーザーの決済の取得時にNotFoundEntityExceptionが投げられる(): void
    {
        $user = $this->app->make(UserRepositoryInterface::class)->findById(2);
        $this->expectException(NotFoundEntityException::class);
        $this->service->findPayment($user, 1);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function makeProviderService_StripeProviderServiceを呼び出す(): void
    {
        $provider = PaymentProvider::STRIPE();
        $providerService = $this->service->makeProviderService($provider);
        $this->assertInstanceOf(PaymentProviderServiceInterface::class, $providerService);
        $this->assertInstanceOf(StripeProviderService::class, $providerService);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function makeProviderService_未実装の決済方法を指定するとUnexpectedValueObjectExceptionが投げられる(): void
    {
        $provider = PaymentProvider::PAYPAY();
        $this->expectException(UnexpectedValueObjectException::class);
        $this->service->makeProviderService($provider);
    }
}
