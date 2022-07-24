<?php

namespace Domain\Domains\DomainService\Payment;

use Domain\Domains\DomainService\Payment\Provider\PaymentProviderServiceInterface;
use Domain\Domains\DomainService\Payment\Provider\StripeProviderService;
use Domain\Domains\Entities\Payment\Payment;
use Domain\Domains\Entities\Payment\PaymentRepositoryInterface;
use Domain\Domains\Entities\User\User;
use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Domain\Exceptions\NotFoundEntityException;
use Domain\Exceptions\UnexpectedValueObjectException;

class PaymentService
{
    private PaymentRepositoryInterface $paymentRepository;

    public function __construct(
        PaymentRepositoryInterface $paymentRepository
    ) {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @param User $user
     * @param int $paymentId
     * @return Payment
     * @throws NotFoundEntityException
     */
    public function findPayment(User $user, int $paymentId): Payment
    {
        $payment = $this->paymentRepository->findById($paymentId);
        $userId = $user->getId();
        if (!$payment || $payment->getUserId() !== $userId) {
            throw new NotFoundEntityException(Payment::class, compact('paymentId', 'userId'));
        }

        return $payment;
    }

    /**
     * @param PaymentProvider $provider
     * @return PaymentProviderServiceInterface
     * @throws UnexpectedValueObjectException
     */
    public function makeProviderService(PaymentProvider $provider): PaymentProviderServiceInterface
    {
        if ($provider->equals(PaymentProvider::STRIPE())) {
            return app(StripeProviderService::class);
        }

        throw new UnexpectedValueObjectException($provider);
    }
}
