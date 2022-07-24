<?php

namespace Domain\Exceptions;

use MyCLabs\Enum\Enum;
use Symfony\Component\HttpFoundation\Response;

class UnexecutableMethodException extends DomainException
{
    /**
     * @param string|Enum $status
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($status, int $code = Response::HTTP_INTERNAL_SERVER_ERROR, \Throwable $previous = null)
    {
        if ($status instanceof Enum) {
            $status = $status->getKey();
        }

        parent::__construct("Unexcutable method when it status was {$status}", $code, $previous);
    }
}
