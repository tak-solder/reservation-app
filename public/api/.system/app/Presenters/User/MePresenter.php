<?php

namespace App\Presenters\User;

use Domain\Domains\Entities\User\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MePresenter implements Responsable
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toResponse($request)
    {
        return new JsonResponse(
            $this->getResponseData(),
            $this->getResponseCode(),
            $this->getResponseHeader(),
            $this->getJsonOptions()
        );
    }

    protected function getResponseData(): array
    {
        return ['user' => $this->user->toArray()];
    }

    protected function getResponseCode(): int
    {
        return Response::HTTP_OK;
    }

    protected function getResponseHeader(): array
    {
        return [];
    }

    protected function getJsonOptions(): int
    {
        return JSON_UNESCAPED_UNICODE;
    }
}
