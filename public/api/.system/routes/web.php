<?php

use App\Http\Controllers\Api\Event\GetEventController;
use App\Http\Controllers\Api\Event\GetEventsController;
use App\Http\Controllers\Api\Payment\CallbackController;
use App\Http\Controllers\Api\Payment\CheckoutController;
use App\Http\Controllers\Api\Payment\CompleteController;
use App\Http\Controllers\Api\Reservation\ConfirmCancelController;
use App\Http\Controllers\Api\Reservation\ExecuteCancelController;
use App\Http\Controllers\Api\Reservation\GetReservationController;
use App\Http\Controllers\Api\Reservation\GetReservationsController;
use App\Http\Controllers\Api\User\MeController;
use App\Http\Controllers\Api\User\SwitchController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    ['prefix' => 'v1'],
    function (Router $router) {
        $router->get('user/me', MeController::class);
        // TODO #1 LINE組み込み時に削除
        $router->get('user/switch', SwitchController::class);

        $router->get('event/get-events', GetEventsController::class);
        $router->get('event/get-event', GetEventController::class);

        $router->get('reservation/get-reservations', GetReservationsController::class);
        $router->get('reservation/get-reservation', GetReservationController::class);
        $router->get('reservation/confirm-cancel', ConfirmCancelController::class);
        $router->get('reservation/execute-cancel', ExecuteCancelController::class);

        $router->post('payment/checkout', CheckoutController::class);
        $router->get('payment/callback', CallbackController::class);
        $router->post('payment/complete', CompleteController::class);
    }
);
