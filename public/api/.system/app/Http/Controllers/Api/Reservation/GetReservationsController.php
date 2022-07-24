<?php

namespace App\Http\Controllers\Api\Reservation;

use App\Http\Controllers\Api\ApiController;
use App\Presenters\JsonPresenter;
use Domain\Exceptions\NotFoundEntityException;
use Domain\UseCases\Inputs\Reservation\GetReservationsValidatesInput;
use Domain\UseCases\Interactor\Reservation\GetReservationsInteractor;
use Illuminate\Http\Request;

class GetReservationsController extends ApiController
{
    protected array $exceptionErrorMessage = [
        NotFoundEntityException::class => '申し込みされたイベントが見つかりませんでした',
    ];

    public function __invoke(Request $request, GetReservationsInteractor $interactor): JsonPresenter
    {
        $input = GetReservationsValidatesInput::fromRequest($request);
        $input->setAuthenticatedUser(auth()->user());
        $output = $interactor->handle($input);

        return new JsonPresenter($output);
    }
}
