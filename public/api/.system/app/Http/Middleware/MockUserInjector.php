<?php

namespace App\Http\Middleware;

use Closure;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\Request;

class MockUserInjector
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('app.infrastructure') === 'session') {
            if ($request->hasSession() && $userId = $request->session()->get('userId')) {
                $user = app(UserRepositoryInterface::class)->findById($userId);
                if ($user) {
                    app(Factory::class)->guard()->setUser($user);
                }
            }
        }

        return $next($request);
    }
}
