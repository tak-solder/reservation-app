<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Api\ApiController;
use App\Presenters\JsonPresenter;
use Domain\UseCases\Inputs\Payment\CompleteValidatesInput;
use Domain\UseCases\Interactor\Payment\CompleteInteractor;
use Domain\UseCases\Outputs\Payment\CompleteOutput;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CompleteController extends ApiController
{
    public function __invoke(Request $request, CompleteInteractor $interactor): JsonPresenter
    {
        $request->session()->keep('paymentId');
        $paymentId = $request->session()->get('paymentId');
        try {
            $input = new CompleteValidatesInput(compact('paymentId'));
        } catch (ValidationException $e) {
            $output = new CompleteOutput(null);
            return new JsonPresenter($output);
        }

        $input->setAuthenticatedUser(auth()->user());
        $output = $interactor->handle($input);

        return new JsonPresenter($output);
    }
}
