<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use ErrorException;
use BadMethodCallException;
use App\Exceptions\ExceptionTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ExceptionTrait;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->renderable(function (Exception $exception, $request) {

            //     // if ($request->expectsJson()) {
            if (
                $request->expectsJson() &&
                $exception instanceof ModelNotFoundException ||
                $exception instanceof NotFoundHttpException ||
                $exception instanceof MethodNotAllowedHttpException ||
                $exception instanceof QueryException ||
                $exception instanceof UnauthorizedException ||
                $exception instanceof ErrorException ||
                $exception instanceof BadMethodCallException
            ) {
                return $this->apiException($request, $exception);
            }
        });
    }
}
