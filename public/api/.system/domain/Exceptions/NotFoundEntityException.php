<?php

namespace Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class NotFoundEntityException extends DomainException
{
    /**
     * @param object|string $entityClass
     * @param array $conditions
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($entityClass, array $conditions = [], int $code = Response::HTTP_NOT_FOUND, \Throwable $previous = null)
    {
        if (is_object($entityClass)) {
            $entityClass = get_class($entityClass);
        }

        if ($conditions) {
            $json = json_encode($conditions, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $message = "Not Found {$entityClass}: {$json}";
        } else {
            $message = "Not Found {$entityClass}";
        }
        parent::__construct($message, $code, $previous);
    }
}
