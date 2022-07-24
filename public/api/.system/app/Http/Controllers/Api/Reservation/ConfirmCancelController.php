<?php

namespace App\Http\Controllers\Api\Reservation;

use App\Http\Controllers\Api\ApiController;
use App\Presenters\JsonPresenter;
use Domain\Exceptions\NotFoundEntityException;
use Domain\UseCases\Inputs\Reservation\ConfirmCancelValidatesInput;
use Domain\UseCases\Interactor\Reservation\ConfirmCancelInteractor;
use Illuminate\Http\Request;

class ConfirmCancelController extends ApiController
{
    protected array $exceptionErrorMessage = [
        NotFoundEntityException::class => '申し込み情報が確認できません',
    ];

    public function __invoke(Request $request, ConfirmCancelInteractor $interactor): JsonPresenter
    {
        $input = ConfirmCancelValidatesInput::fromRequest($request);
        $input->setAuthenticatedUser(auth()->user());
        $output = $interactor->handle($input);

        return new JsonPresenter($output);
    }
}
