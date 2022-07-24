<?php

namespace Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UnexpectedResponseException extends DomainException
{
    public function __construct(object $class, string $method, array $response, int $code = Response::HTTP_INTERNAL_SERVER_ERROR, \Throwable $previous = null)
    {
        $class = get_class($class);
        $json = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $message = "Unexpected Response {$class}::{$method}() => {$json}";

        parent::__construct($message, $code, $previous);
    }
}
