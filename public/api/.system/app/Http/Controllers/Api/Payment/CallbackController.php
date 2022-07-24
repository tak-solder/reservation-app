<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Api\ApiController;
use App\Presenters\Payment\CallbackPresenter;
use Domain\Exceptions\InconsistencyException;
use Domain\UseCases\Inputs\Payment\CallbackValidatesInput;
use Domain\UseCases\Interactor\Payment\CallbackInteractor;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;

class CallbackController extends ApiController
{
    /**
     * @param Request $request
     * @param CallbackInteractor $interactor
     * @return CallbackPresenter|\Illuminate\Contracts\View\View
     */
    public function __invoke(Request $request, CallbackInteractor $interactor)
    {
        try {
            $input = CallbackValidatesInput::fromRequest($request);
            $input->setAuthenticatedUser(auth()->user());
            $output = $interactor->handle($input);

            return new CallbackPresenter($output);
        } catch (InconsistencyException $exception) {
            app(ExceptionHandler::class)->report($exception);
            $message = $exception->getMessage();
        } catch (\Throwable $exception) {
            app(ExceptionHandler::class)->report($exception);
            $message = "予約処理中にエラーが発生しました。予約が完了していない場合は再度お試しください。";
        }

        // TODO #14 react側でエラー表示
        return view('payment.callback-error', compact('message'));
    }
}
