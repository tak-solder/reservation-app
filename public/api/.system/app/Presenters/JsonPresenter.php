<?php

namespace App\Presenters;

use Domain\UseCases\Outputs\OutputInterface;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonPresenter implements Responsable
{
    protected OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
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
        return $this->output->toArray();
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
