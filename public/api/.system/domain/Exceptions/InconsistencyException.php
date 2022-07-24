<?php

namespace Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class InconsistencyException extends DomainException
{
    public function __construct(string $message = "", int $code = Response::HTTP_CONFLICT, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
