<?php

namespace Domain\Infrastructures\Api\PaymentProvider\Stripe;

use Carbon\Carbon;
use Domain\Domains\Entities\Payment\Provider\Stripe\Checkout\CheckoutRequest;
use Domain\Domains\Entities\Payment\Provider\Stripe\StripePaymentData;
use Domain\Domains\ValueObject\Payment\Item\PaymentItemType;
use Domain\Domains\ValueObject\Payment\ProviderPaymentStatus;
use Domain\Exceptions\UnexpectedResponseException;
use Stripe\StripeClient;

class StripePaymentRepository implements StripeRepositoryInterface
{
    private StripeClient $client;
    //private array $config;

    public function __construct(StripeClient $client)
    {
        $this->client = $client;
        //$this->config = config('payment.stripe');
    }

    public function checkout(CheckoutRequest $request): StripePaymentData
    {
        $session = $this->client->checkout->sessions->create([
            'line_items' => $request->getLineItems(),
            'mode' => 'payment',
            'payment_intent_data' => [
                'capture_method' => 'manual',
            ],
            'expires_at' => Carbon::now()->addHours()->getTimestamp(),
            'success_url' => $request->getSuccessUrl(),
            'cancel_url' => $request->getCancelUrl(),
            'metadata' => [
                'paymentId' => $request->getPaymentId(),
            ]
        ]);

        return new StripePaymentData($session->toArray());
    }

    public function addItemPrice(PaymentItemType $itemType, int $amount): array
    {
        // TODO #3 仮状態の為、コメントアウト
        throw new \Exception('未実装の機能');
        /*
        $productId = $this->config['products'][$itemType->getKey()] ?? null;
        if (!$productId) {
            throw new \UnexpectedValueException("登録されていない商品: stripe.products.{$itemType->getKey()}");
        }

        $price = $this->client->prices->create([
            'currency' => 'jpy',
            'product' => $productId,
            'unit_amount' => $amount,
        ]);
        return $price->toArray();
        */
    }

    public function getProviderStatus(string $providerId): ProviderPaymentStatus
    {
        $intent = $this->client->paymentIntents->retrieve($providerId);
        switch ($intent['status']) {
            case 'requires_payment_method':
                return ProviderPaymentStatus::CREATED();

            case 'requires_capture':
                return ProviderPaymentStatus::AUTHORIZATION();

            case 'canceled':
                return ProviderPaymentStatus::CANCELED();

            case 'succeeded':
                return ProviderPaymentStatus::COMPLETED();
        }

        throw new \UnexpectedValueException("Unexpected Stripe paymentIntents status: {$intent['status']}");
    }

    /**
     * @param string $providerId
     * @return void
     * @throws UnexpectedResponseException
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function capture(string $providerId): void
    {
        $response = $this->client->paymentIntents->retrieve($providerId)->capture();
        if ($response->status !== 'succeeded') {
            throw new UnexpectedResponseException($this, __METHOD__, $response->toArray());
        }
    }

    /**
     * @param string $providerId
     * @param int $amount
     * @return void
     * @throws UnexpectedResponseException
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function refund(string $providerId, int $amount): void
    {
        $response = $this->client->refunds->create([
            'payment_intent' => $providerId,
            'amount' => $amount,
        ]);
        if ($response->status !== 'succeeded') {
            throw new UnexpectedResponseException($this, __METHOD__, $response->toArray());
        }
    }
}
