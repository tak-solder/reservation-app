<?php

namespace Tests\Unit\Domain\Domains\DomainService\Payment\Provider;

use Domain\Domains\DomainService\Payment\Provider\StripeProviderService;
use Domain\Domains\Entities\Event\Event;
use Domain\Domains\Entities\Event\EventRepositoryInterface;
use Domain\Domains\Entities\Payment\Order\Order;
use Domain\Domains\Entities\Payment\Payment;
use Domain\Domains\Entities\Payment\PaymentRepositoryInterface;
use Domain\Domains\Entities\Payment\Provider\Stripe\StripePaymentData;
use Domain\Domains\Entities\User\User;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Domain\Exceptions\InvalidValueException;
use Domain\Exceptions\UnexecutableMethodException;
use Domain\Infrastructures\Api\PaymentProvider\Stripe\StripeRepositoryInterface;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Tests\TestCase;

class StripeProviderServiceTest extends TestCase
{
    /**
     * StripeRepositoryInterfaceをモックしたStripeProviderServiceを生成
     * @param \Closure(MockInterface): void $callback
     * @return StripeProviderService
     */
    private function makeServiceWithMockRepository(\Closure $callback): StripeProviderService
    {
        $this->mock(StripeRepositoryInterface::class, $callback);
        return $this->app->make(StripeProviderService::class);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function createPayment_申込内容から決済URLを発行(): void
    {
        $service = $this->makeServiceWithMockRepository(
            function (MockInterface $mock) {
                $mock->shouldReceive('checkout')
                    ->once()
                    ->andReturn(new StripePaymentData([
                        'payment_intent' => 'stripe_test',
                        'url' => 'https://example.com/stripe_test'
                    ]));
            }
        );

        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);
        /** @var Event $event */
        $event = $this->app->make(EventRepositoryInterface::class)->findById(1);
        $orders = new Collection([
            new Order(
                $event->getId(),
                new Collection([]),
                $event->getCost(),
            )
        ]);
        $payment = $service->createPayment($user, $orders, 'https://example.com/success', 'https://example.com/cancel');

        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertEquals('stripe_test', $payment->getProviderId());
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function completePayment_オーソリ中の決済をキャプチャする(): void
    {
        $service = $this->makeServiceWithMockRepository(
            function (MockInterface $mock) {
                $mock->shouldReceive('checkout')
                    ->once()
                    ->andReturn(new StripePaymentData([
                        'payment_intent' => 'stripe_test',
                        'url' => 'https://example.com/stripe_test'
                    ]));
                $mock->shouldReceive('capture')
                    ->once();
            }
        );

        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);
        /** @var Event $event */
        $event = $this->app->make(EventRepositoryInterface::class)->findById(1);
        $orders = new Collection([
            new Order(
                $event->getId(),
                new Collection([]),
                $event->getCost(),
            )
        ]);
        $payment = $service->createPayment($user, $orders, 'https://example.com/success', 'https://example.com/cancel');

        $service->completePayment($payment);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function completePayment_決済済みのデータをキャプチャすると、UnexecutableMethodExceptionが投げられる(): void
    {
        $service = $this->makeServiceWithMockRepository(function (MockInterface $mock) {});


        /** @var Payment $payment */
        $payment = $this->app->make(PaymentRepositoryInterface::class)->findById(1);
        $this->expectException(UnexecutableMethodException::class);
        $service->completePayment($payment);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function refundPayment_確定済みの決済で指定金額だけ返金する(): void
    {
        $service = $this->makeServiceWithMockRepository(
            function (MockInterface $mock) {
                $mock->shouldReceive('refund')
                    ->once();
            }
        );

        /** @var Payment $payment */
        $payment = $this->app->make(PaymentRepositoryInterface::class)->findById(1);
        $service->refundPayment($payment, 500);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function refundPayment_決済金額以上を返金しようとするとInvalidValueExceptionが投げられる(): void
    {
        $service = $this->makeServiceWithMockRepository(function (MockInterface $mock) {});

        /** @var Payment $payment */
        $payment = $this->app->make(PaymentRepositoryInterface::class)->findById(1);
        $this->expectException(InvalidValueException::class);
        $service->refundPayment($payment, 5000);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function refundPayment_返金済みの決済を再返金しようとするとUnexecutableMethodExceptionが投げられる(): void
    {
        $service = $this->makeServiceWithMockRepository(function (MockInterface $mock) {});

        /** @var Payment $payment */
        $payment = $this->app->make(PaymentRepositoryInterface::class)->findById(4);
        $this->expectException(UnexecutableMethodException::class);
        $service->refundPayment($payment, 500);
    }
}
