<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Api\ApiController;
use App\Presenters\JsonPresenter;
use Domain\Exceptions\NotFoundEntityException;
use Domain\UseCases\Inputs\Event\GetEventsValidatesInput;
use Domain\UseCases\Interactor\Event\GetEventsInteractor;
use Illuminate\Http\Request;

class GetEventsController extends ApiController
{
    protected array $exceptionErrorMessage = [
        NotFoundEntityException::class => 'イベントの情報が取得できません',
    ];

    public function __invoke(Request $request, GetEventsInteractor $interactor): JsonPresenter
    {
        $input = GetEventsValidatesInput::fromRequest($request);
        $input->setAuthenticatedUser(auth()->user());
        $output = $interactor->handle($input);

        return new JsonPresenter($output);
    }
}
