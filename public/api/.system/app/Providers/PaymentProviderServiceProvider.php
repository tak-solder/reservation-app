<?php

namespace App\Providers;

use Domain\Infrastructures\Api\PaymentProvider\Stripe\StripePaymentRepository;
use Domain\Infrastructures\Api\PaymentProvider\Stripe\StripeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class PaymentProviderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(StripeRepositoryInterface::class, StripePaymentRepository::class);
    }
}
