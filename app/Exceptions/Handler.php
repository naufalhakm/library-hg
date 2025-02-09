<?php

namespace App\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: Please provide a valid token',
            ], 401);
        }

        if ($exception instanceof TokenExpiredException) {
            return response()->json([
                'status' => false,
                'message' => 'Token expired',
            ], 401);
        }

        if ($exception instanceof TokenInvalidException) {
            return response()->json([
                'status' => false,
                'message' => 'Token invalid',
            ], 401);
        }

        if ($exception instanceof JWTException) {
            return response()->json([
                'status' => false,
                'message' => 'Token not provided',
            ], 401);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        return parent::render($request, $exception);
    }
}
