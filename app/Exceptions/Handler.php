<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (TooManyRequestsHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;
                $message = trans('messages.rate_limit_exceeded', ['seconds' => $retryAfter]);

                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'errors' => [
                        'rate_limit' => [$message]
                    ],
                    'retry_after' => $retryAfter
                ], 429);
            }
        });
    }
}
