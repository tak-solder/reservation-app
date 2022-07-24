<?php

namespace App\Http\Controllers\Api\Reservation;

use App\Http\Controllers\Api\ApiController;
use App\Presenters\JsonPresenter;
use Domain\Exceptions\InconsistencyException;
use Domain\Exceptions\NotFoundEntityException;
use Domain\UseCases\Inputs\Reservation\ExecuteCancelValidatesInput;
use Domain\UseCases\Interactor\Reservation\ExecuteCancelInteractor;
use Illuminate\Http\Request;

class ExecuteCancelController extends ApiController
{
    protected array $exceptionErrorMessage = [
        NotFoundEntityException::class => '申し込み情報が確認できません',
        InconsistencyException::class => 'キャンセル時の内容が更新されました。もう一度キャンセルをお試しください',
    ];

    public function __invoke(Request $request, ExecuteCancelInteractor $interactor): JsonPresenter
    {
        $input = ExecuteCancelValidatesInput::fromRequest($request);
        $input->setAuthenticatedUser(auth()->user());
        $output = $interactor->handle($input);

        return new JsonPresenter($output);
    }
}
