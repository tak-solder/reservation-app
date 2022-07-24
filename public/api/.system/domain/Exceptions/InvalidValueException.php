<?php

namespace Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class InvalidValueException extends DomainException
{
    /**
     * @param object $class
     * @param string $property
     * @param mixed $given
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(object $class, string $property, $given, int $code = Response::HTTP_INTERNAL_SERVER_ERROR, \Throwable $previous = null)
    {
        $class = get_class($class);
        if (is_object($given)) {
            $given = get_class($given);
        }
        $message = "Invalid value set {$class}::\${$property} = {$given}";

        parent::__construct($message, $code, $previous);
    }
}
