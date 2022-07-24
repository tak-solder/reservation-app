<?php

namespace Domain\Infrastructures\Mock\Repositories;

use Carbon\CarbonImmutable;
use Domain\Domains\Entities\Payment\History\UpdateHistory;
use Domain\Domains\Entities\Payment\Order\Order;
use Domain\Domains\Entities\Payment\Payment;
use Domain\Domains\Entities\Payment\PaymentRepositoryInterface;
use Domain\Domains\Entities\Payment\Provider\Stripe\StripePaymentData;
use Domain\Domains\Entities\Reservation\Options\ReservationOption;
use Domain\Domains\ValueObject\EventOption\OptionKey;
use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Domain\Domains\ValueObject\Payment\PaymentStatus;
use Domain\Exceptions\NotFoundEntityException;
use Domain\Infrastructures\Mock\Utilities\CollectionQueries;
use Illuminate\Support\Collection;

class MockPaymentRepository implements PaymentRepositoryInterface
{
    use CollectionQueries;

    public function __construct()
    {
        $now = CarbonImmutable::now();
        if ($this->load()) {
            return;
        }

        $this->collection = new Collection([
            new Payment(
                1,
                1,
                PaymentProvider::STRIPE(),
                'mock_stripe',
                new StripePaymentData(['payment_intent' => 'stripe1', 'url' => 'https://example.com/stripe1',]),
                PaymentStatus::COMPLETED(),
                1500,
                0,
                new Collection([
                    new Order(
                        4,
                        new Collection([
                            new ReservationOption(
                                OptionKey::EXTRA_TIME,
                                0
                            ),
                        ]),
                        1500
                    )
                ]),
                new Collection([
                    new UpdateHistory(
                        PaymentStatus::REQUESTED(),
                        $now->subHours(3),
                    ),
                    new UpdateHistory(
                        PaymentStatus::COMPLETED(),
                        $now->subHours(3)->addMinutes(3),
                    )
                ])
            ),
            new Payment(
                2,
                1,
                PaymentProvider::PAYPAY(),
                'mock_stripe',
                new StripePaymentData(['payment_intent' => 'stripe', 'url' => 'https://example.com/stripe2',]),
                PaymentStatus::COMPLETED(),
                3500,
                0,
                new Collection([
                    new Order(
                        8,
                        new Collection([
                            new ReservationOption(
                                OptionKey::EXTRA_TIME,
                                2
                            ),
                        ]),
                        3500
                    )
                ]),
                new Collection([
                    new UpdateHistory(
                        PaymentStatus::REQUESTED(),
                        $now->subHours(2),
                    ),
                    new UpdateHistory(
                        PaymentStatus::COMPLETED(),
                        $now->subHours(2)->addMinutes(5),
                    )
                ])
            ),
            new Payment(
                3,
                1,
                PaymentProvider::STRIPE(),
                'mock_stripe',
                new StripePaymentData(['payment_intent' => 'stripe3', 'url' => 'https://example.com/stripe3',]),
                PaymentStatus::COMPLETED(),
                3500,
                0,
                new Collection([
                    new Order(
                        9,
                        new Collection([
                            new ReservationOption(
                                OptionKey::EXTRA_TIME,
                                2
                            ),
                        ]),
                        3500
                    )
                ]),
                new Collection([
                    new UpdateHistory(
                        PaymentStatus::REQUESTED(),
                        $now->subDays(2),
                    ),
                    new UpdateHistory(
                        PaymentStatus::COMPLETED(),
                        $now->subDays(2)->addMinutes(5),
                    )
                ])
            ),
            new Payment(
                4,
                1,
                PaymentProvider::STRIPE(),
                'mock_stripe',
                new StripePaymentData(['payment_intent' => 'stripe4', 'url' => 'https://example.com/stripe4',]),
                PaymentStatus::REFUNDED(),
                1500,
                750,
                new Collection([
                    new Order(
                        10,
                        new Collection([
                            new ReservationOption(
                                OptionKey::EXTRA_TIME,
                                0
                            ),
                        ]),
                        1500
                    )
                ]),
                new Collection([
                    new UpdateHistory(
                        PaymentStatus::REQUESTED(),
                        $now->subDays(3),
                    ),
                    new UpdateHistory(
                        PaymentStatus::COMPLETED(),
                        $now->subDays(3)->addMinutes(5),
                    ),
                    new UpdateHistory(
                        PaymentStatus::CANCELED(),
                        $now->subDays(2)->subHours(3),
                    )
                ])
            ),
            new Payment(
                5,
                2,
                PaymentProvider::STRIPE(),
                'mock_stripe',
                new StripePaymentData(['payment_intent' => 'stripe4', 'url' => 'https://example.com/stripe4',]),
                PaymentStatus::REFUNDED(),
                1650,
                0,
                new Collection([
                    new Order(
                        9,
                        new Collection([
                            new ReservationOption(
                                OptionKey::EXTRA_TIME,
                                0
                            ),
                        ]),
                        1650
                    )
                ]),
                new Collection([
                    new UpdateHistory(
                        PaymentStatus::REQUESTED(),
                        $now->subDays(3),
                    ),
                    new UpdateHistory(
                        PaymentStatus::COMPLETED(),
                        $now->subDays(3)->addMinutes(5),
                    ),
                    new UpdateHistory(
                        PaymentStatus::CANCELED(),
                        $now->subDays(2)->subHours(3),
                    )
                ])
            ),
        ]);
    }

    public function findById(int $id): ?Payment
    {
        return $this->find(fn(Payment $payment) => $payment->getId() === $id);
    }

    public function getPayments(
        int $userId
    ): Collection {
        return $this->filter(function (Payment $payment) use ($userId) {
            if ($userId !== $payment->getUserId()) {
                return false;
            }

            return true;
        });
    }

    public function createPayment(int $userId, PaymentProvider $provider, Collection $orders, int $amount): Payment
    {
        $payment = new Payment(
            $this->getMaxId() + 1,
            $userId,
            $provider,
            null,
            null,
            PaymentStatus::CREATED(),
            $amount,
            0,
            $orders,
            new Collection([])
        );
        $this->collection->push($payment);
        $this->persistence();


        return $payment;
    }

    /**
     * @param Payment $payment
     * @return void
     * @throws NotFoundEntityException
     */
    public function updatePayment(Payment $payment): void
    {
        $this->replaceEntity($payment->getId(), $payment);
        $this->persistence();
    }
}
