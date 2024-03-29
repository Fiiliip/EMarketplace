<?php namespace WApi\ApiException\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use October\Rain\Auth\AuthException;

trait ApiResponse
{
    public static function apiErrorResponse($exception, $statusCode = null)
    {
        $message = $exception->getMessage();

        $exceptionStatusCode = 500;
        if (method_exists($exception, 'getStatusCode')) {
            $exceptionStatusCode = $exception->getStatusCode();
        } elseif (method_exists($exception, 'getCode')) {
            $exceptionStatusCode = $exception->getCode();
        }

        if ($exceptionStatusCode < 100 || $exceptionStatusCode > 511 || !(is_int($exceptionStatusCode)) ) {
            $exceptionStatusCode = 500;
        }

        if ($exception instanceof ModelNotFoundException) {
            $message = sprintf('%s not found',
                array_last(explode('\\', $exception->getModel()))
            );
            $exceptionStatusCode = 404;
        } elseif ($exception instanceof ValidationException) {
            $message = $exception->getMessage();
            $exceptionStatusCode = 422;
        } elseif ($exception instanceof AuthException && $exception->getCode() >= 200 && $exception->getCode() < 300) {
            $message = $exception->getMessage();
            $exceptionStatusCode = 401;
        } else {
            Event::fire('exception.report', [$exception]);
        }

        if ($statusCode) {
            $exceptionStatusCode = $statusCode;
        }

        $content = [
            'error' => $message,
            'statusCode' => $exceptionStatusCode
        ];

        $response = Event::fire('wezeo.api.error.response', [$content, $exception], true);
        if ($response) {
            if ($response instanceof Response) {
                return $response;
            }

            $content = $response;
        }

        return new Response($content, $content['statusCode'] ?? $exceptionStatusCode);
    }
}
