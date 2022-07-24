<?php

namespace Domain\Domains\Entities\Payment;

use Carbon\CarbonImmutable;
use Domain\Domains\Entities\EntityInterface;
use Domain\Domains\Entities\Payment\History\UpdateHistory;
use Domain\Domains\Entities\Payment\Provider\PaymentDataInterface;
use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Domain\Domains\ValueObject\Payment\PaymentStatus;
use Domain\Exceptions\InvalidValueException;
use Domain\Exceptions\UnexecutableMethodException;
use Illuminate\Support\Collection;

class Payment implements EntityInterface
{
    private int $id;
    private int $userId;
    private PaymentProvider $provider;
    private ?string $providerId;
    private ?PaymentDataInterface $paymentData;
    private PaymentStatus $status;
    private int $amount;
    private int $refund;
    private Collection $orders;
    private Collection $updateHistory;

    public function __construct(
        int $id,
        int $userId,
        PaymentProvider $provider,
        ?string $providerId,
        ?PaymentDataInterface $paymentData,
        PaymentStatus $status,
        int $amount,
        int $refund,
        Collection $orders,
        Collection $updateHistory
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->provider = $provider;
        $this->providerId = $providerId;
        $this->paymentData = $paymentData;
        $this->status = $status;
        $this->amount = $amount;
        $this->refund = $refund;
        $this->orders = $orders;
        $this->updateHistory = $updateHistory;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProvider(): PaymentProvider
    {
        return $this->provider;
    }

    public function getStatus(): PaymentStatus
    {
        return $this->status;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getRefund(): int
    {
        return $this->refund;
    }

    public function getProviderId(): string
    {
        return $this->providerId;
    }

    public function getPaymentData(): PaymentDataInterface
    {
        return $this->paymentData;
    }

    /**
     * @param PaymentDataInterface $data
     * @return void
     * @throws UnexecutableMethodException
     */
    public function requestPayment(PaymentDataInterface $data): void
    {
        if (!$this->status->equals(PaymentStatus::CREATED())) {
            throw new UnexecutableMethodException($this->status);
        }

        $this->providerId = $data->getProviderId();
        $this->paymentData = $data;
        $this->status = PaymentStatus::REQUESTED();
        $this->updateHistory->push(new UpdateHistory($this->status, CarbonImmutable::now()));
    }

    /**
     * @param PaymentDataInterface|null $data
     * @return void
     * @throws UnexecutableMethodException
     */
    public function completedPayment(?PaymentDataInterface $data = null): void
    {
        if (!$this->status->equals(PaymentStatus::REQUESTED())) {
            throw new UnexecutableMethodException($this->status);
        }

        if ($data) {
            $this->paymentData = $data;
        }
        $this->status = PaymentStatus::COMPLETED();
        $this->updateHistory->push(new UpdateHistory($this->status, CarbonImmutable::now()));
    }

    /**
     * @param int $refundAmount
     * @param PaymentDataInterface|null $data
     * @return void
     * @throws InvalidValueException
     * @throws UnexecutableMethodException
     */
    public function refundPayment(int $refundAmount, ?PaymentDataInterface $data = null): void
    {
        if ($this->status->equals(PaymentStatus::REFUNDED())) {
            throw new UnexecutableMethodException($this->status);
        }

        $this->refund += $refundAmount;
        if ($this->amount < $this->refund) {
            throw new InvalidValueException($this, 'refund', $refundAmount);
        }

        if ($data) {
            $this->paymentData = $data;
        }
        $this->status = PaymentStatus::REFUNDED();
        $this->updateHistory->push(new UpdateHistory($this->status, CarbonImmutable::now()));
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function getUpdateHistory(): Collection
    {
        return $this->updateHistory;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'provider' => $this->provider->getValue(),
            'providerId' => $this->providerId,
            'status' => $this->status->getValue(),
            'amount' => $this->amount,
            'refund' => $this->refund,
            'orders' => $this->orders->toArray(),
        ];
    }
}
