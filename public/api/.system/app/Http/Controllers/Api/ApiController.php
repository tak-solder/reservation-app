<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Domain\Exceptions\DomainException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Support\Responsable;

abstract class ApiController extends Controller
{
    use MakeDomainErrorResponse;

    /**
     * @param string $method
     * @param array $parameters
     * @return \Symfony\Component\HttpFoundation\Response|Responsable
     */
    public function callAction($method, $parameters)
    {
        try {
            return parent::callAction($method, $parameters);
        } catch (DomainException $exception) {
            app(ExceptionHandler::class)->report($exception);
            return $this->makeDomainErrorResponse($exception);
        }
    }
}
