<?php

namespace App\Presenters\Error;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class ErrorJsonPresenter implements Responsable
{
    protected string $message;
    protected int $code;

    public function __construct(string $message, int $code)
    {
        $this->message = $message;
        $this->code = $code;
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
        return ['error' => $this->message, 'code' => $this->code];
    }

    protected function getResponseCode(): int
    {
        return $this->code;
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
