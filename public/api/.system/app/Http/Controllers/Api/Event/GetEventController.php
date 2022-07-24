<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Api\ApiController;
use App\Presenters\JsonPresenter;
use Domain\Exceptions\NotFoundEntityException;
use Domain\UseCases\Inputs\Event\GetEventValidatesInput;
use Domain\UseCases\Interactor\Event\GetEventInteractor;
use Illuminate\Http\Request;

class GetEventController extends ApiController
{
    protected array $exceptionErrorMessage = [
        NotFoundEntityException::class => 'イベントが存在しません',
    ];

    public function __invoke(Request $request, GetEventInteractor $interactor): JsonPresenter
    {
        $input = GetEventValidatesInput::fromRequest($request);
        $input->setAuthenticatedUser(auth()->user());
        $output = $interactor->handle($input);

        return new JsonPresenter($output);
    }
}
