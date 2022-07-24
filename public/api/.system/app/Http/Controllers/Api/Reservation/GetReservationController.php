<?php

namespace App\Http\Controllers\Api\Reservation;

use App\Http\Controllers\Api\ApiController;
use App\Presenters\JsonPresenter;
use Domain\Exceptions\NotFoundEntityException;
use Domain\UseCases\Inputs\Reservation\GetReservationValidatesInput;
use Domain\UseCases\Interactor\Reservation\GetReservationInteractor;
use Illuminate\Http\Request;

class GetReservationController extends ApiController
{
    protected array $exceptionErrorMessage = [
        NotFoundEntityException::class => '申し込み情報が取得出来ませんでした',
    ];

    public function __invoke(Request $request, GetReservationInteractor $interactor): JsonPresenter
    {
        $input = GetReservationValidatesInput::fromRequest($request);
        $input->setAuthenticatedUser(auth()->user());
        $output = $interactor->handle($input);

        return new JsonPresenter($output);
    }
}
