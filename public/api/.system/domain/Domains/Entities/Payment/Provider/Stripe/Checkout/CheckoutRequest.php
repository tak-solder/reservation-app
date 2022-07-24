<?php

namespace Domain\Domains\Entities\Payment\Provider\Stripe\Checkout;

use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class CheckoutRequest implements Arrayable
{
    private int $paymentId;
    private Collection $checkoutOrders;
    private string $successUrl;
    private string $cancelUrl;

    public function __construct(int $paymentId, Collection $checkoutOrders, string $successUrl, string $cancelUrl)
    {
        $this->paymentId = $paymentId;
        $this->checkoutOrders = $checkoutOrders;
        $this->successUrl = $successUrl;
        $this->cancelUrl = $cancelUrl;
    }

    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    public function getProvider(): PaymentProvider
    {
        return PaymentProvider::STRIPE();
    }

    public function getAmount(): int
    {
        return $this->checkoutOrders->sum(fn(CheckoutOrder $checkoutOrder) => $checkoutOrder->getTotalAmount());
    }

    public function toArray()
    {
        return [
            'paymentId' => $this->paymentId,
            'checkoutOrders' => $this->checkoutOrders->toArray(),
            'successUrl' => $this->successUrl,
            'cancelUrl' => $this->cancelUrl,
        ];
    }

    public function getCheckoutOrders(): Collection
    {
        return $this->checkoutOrders;
    }

    public function getLineItems(): array
    {
        return $this->checkoutOrders
            ->flatMap(fn(CheckoutOrder $order) => $order->getLineItemList())
            ->all();
    }

    public function getSuccessUrl(): string
    {
        return $this->successUrl;
    }

    public function getCancelUrl(): string
    {
        return $this->cancelUrl;
    }
}
