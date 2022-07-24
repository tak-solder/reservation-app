<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Api\ApiController;
use App\Presenters\JsonPresenter;
use App\Presenters\Payment\CheckoutPresenter;
use Domain\UseCases\Inputs\Payment\CheckoutValidatesInput;
use Domain\UseCases\Interactor\Payment\CheckoutInteractor;
use Illuminate\Http\Request;

class CheckoutController extends ApiController
{
    public function __invoke(Request $request, CheckoutInteractor $interactor): JsonPresenter
    {
        $input = CheckoutValidatesInput::fromRequest($request);
        $input->setAuthenticatedUser(auth()->user());
        $eventId = $input->getOrders()->first()->getEventId();
        $input->setUrl(
            api_url('/payment/callback?paymentId={paymentId}'),
            app_url("/reservation/event/{$eventId}")
        );
        $output = $interactor->handle($input);

        return new CheckoutPresenter($output);
    }
}
