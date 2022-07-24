<?php

namespace App\Http\Controllers\Api;

use App\Presenters\Error\ErrorJsonPresenter;
use Domain\Exceptions\DomainException;
use Domain\Exceptions\InconsistencyException;
use Domain\Exceptions\NotFoundEntityException;

trait MakeDomainErrorResponse
{
    protected string $default4xxMessage = 'エラーが発生しました。データが存在しないか、一時的に処理できない状態になっております。';
    protected string $default5xxMessage = '通信エラーが発生しました。一度前の画面に戻って再度お試しください。';
    protected array $exceptionErrorMessage = [
        NotFoundEntityException::class => 'データが存在しません',
        InconsistencyException::class => 'イベントの状態が変更された可能性がございます。ページを表示し直してから、再度お試しください。',
    ];

    protected function makeDomainErrorResponse(DomainException $exception): ErrorJsonPresenter
    {
        return new ErrorJsonPresenter(
            $this->getMessage($exception),
            $this->getCode($exception)
        );
    }

    protected function getMessage(DomainException $exception): string
    {
        $class = get_class($exception);
        if (isset($this->exceptionErrorMessage[$class])) {
            return $this->exceptionErrorMessage[$class];
        }
        return $this->getCode($exception) < 500 ? $this->default4xxMessage : $this->default5xxMessage;
    }

    protected function getCode(DomainException $exception): int
    {
        return $exception->getCode();
    }
}
