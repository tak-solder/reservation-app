<?php

namespace Domain\UseCases\Inputs\Payment;

use App\Validation\Rules\Payment\OptionValues;
use Domain\Domains\Entities\Payment\Order\Order;
use Domain\Domains\Entities\Reservation\Options\ReservationOption;
use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Domain\UseCases\Inputs\ValidatesInput;
use Domain\UseCases\Inputs\WithAuthenticatedUser;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CheckoutValidatesInput extends ValidatesInput
{
    use WithAuthenticatedUser;

    private string $successUrl;
    private string $cancelUrl;

    protected function rules(): array
    {
        return [
            'provider' => [
                'required',
                'int',
                Rule::in(PaymentProvider::values()),
            ],
            'order' => ['required', 'array'],
            'order.eventId' => ['required', 'int', 'min:0'],
            'order.optionValues' => ['array', new OptionValues()],
        ];
    }

    public function setUrl(string $successUrl, string $cancelUrl): void
    {
        $this->successUrl = $successUrl;
        $this->cancelUrl = $cancelUrl;
    }

    public function getProvider(): PaymentProvider
    {
        return PaymentProvider::from($this->inputs['provider']);
    }

    public function getOrders(): Collection
    {
        $order = $this->inputs['order'];
        return new Collection([
            new Order(
                intval($order['eventId']),
                collect($order['optionValues'])->map(function ($value, $key) {
                    return new ReservationOption($key, $value);
                }),
                null
            )
        ]);
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
