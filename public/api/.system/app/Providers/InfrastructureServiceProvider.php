<?php

namespace App\Providers;

use App\Auth\Guard\MockGuard;
use Domain\Domains\Entities\Event\EventRepositoryInterface;
use Domain\Domains\Entities\Payment\Item\PaymentItemRepositoryInterface;
use Domain\Domains\Entities\Payment\PaymentRepositoryInterface;
use Domain\Domains\Entities\Reservation\ReservationRepositoryInterface;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Domain\Infrastructures\Mock\Repositories\MockEventRepository;
use Domain\Infrastructures\Mock\Repositories\MockPaymentItemRepository;
use Domain\Infrastructures\Mock\Repositories\MockPaymentRepository;
use Domain\Infrastructures\Mock\Repositories\MockReservationRepository;
use Domain\Infrastructures\Mock\Repositories\MockUserRepository;
use Domain\Infrastructures\Session\Repositories\SessionEventRepository;
use Domain\Infrastructures\Session\Repositories\SessionPaymentItemRepository;
use Domain\Infrastructures\Session\Repositories\SessionPaymentRepository;
use Domain\Infrastructures\Session\Repositories\SessionReservationRepository;
use Domain\Infrastructures\Session\Repositories\SessionUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Factory;

class InfrastructureServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        switch (config('app.infrastructure')) {
            case 'mock':
                $this->mock();
                break;

            case 'session':
                $this->session();
                break;

            default:
                throw new \UnexpectedValueException('Unexpected environment: INFRASTRUCTURE= "' . config('app.infrastructure') . '"');
        }
    }

    public function boot(): void
    {
        if (config('auth.defaults.guard') === 'mock') {
            Auth::extend('mock', function () {
                return new MockGuard();
            });
        }
    }

    private function mock(): void
    {
        $this->app->singleton(EventRepositoryInterface::class, MockEventRepository::class);
        $this->app->singleton(PaymentItemRepositoryInterface::class, MockPaymentItemRepository::class);
        $this->app->singleton(PaymentRepositoryInterface::class, MockPaymentRepository::class);
        $this->app->singleton(ReservationRepositoryInterface::class, MockReservationRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, MockUserRepository::class);
    }

    private function session(): void
    {
        $this->app->singleton(EventRepositoryInterface::class, SessionEventRepository::class);
        $this->app->singleton(PaymentItemRepositoryInterface::class, SessionPaymentItemRepository::class);
        $this->app->singleton(PaymentRepositoryInterface::class, SessionPaymentRepository::class);
        $this->app->singleton(ReservationRepositoryInterface::class, SessionReservationRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, SessionUserRepository::class);
    }
}
