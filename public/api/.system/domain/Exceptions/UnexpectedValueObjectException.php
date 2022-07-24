<?php

namespace Domain\Exceptions;

use MyCLabs\Enum\Enum;
use Symfony\Component\HttpFoundation\Response;

class UnexpectedValueObjectException extends DomainException
{
    public function __construct(Enum $enum, int $code = Response::HTTP_INTERNAL_SERVER_ERROR, \Throwable $previous = null)
    {
        $class = get_class($enum);
        $key = $enum->getKey();
        $value = $enum->getValue();
        $message = "Unexpected ValueObject {$class}: {$key} => {$value}";

        parent::__construct($message, $code, $previous);
    }
}
