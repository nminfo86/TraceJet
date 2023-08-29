<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use ErrorException;
use App\Traits\ResponseTrait;
use App\Exceptions\ExceptionTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Mockery\Exception\BadMethodCallException;
use Illuminate\Auth\Access\AuthorizationException;

use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class Handler extends ExceptionHandler
{
    // use ResponseTrait;
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
            // dd($exception);
            // if ($request->expectsJson()) {
            //     if (

            //         $exception instanceof ModelNotFoundException ||
            //         $exception instanceof NotFoundHttpException ||
            //         $exception instanceof MethodNotAllowedHttpException ||
            //         $exception instanceof QueryException ||
            //         $exception instanceof UnauthorizedException ||
            //         $exception instanceof ErrorException ||
            //         $exception instanceof BadMethodCallException ||
            //         $exception instanceof AuthenticationException
            //     ) {
            //         return $this->apiException($request, $exception);
            //     }
            // }


            if ($request->expectsJson()) {
                // $exceptionTypesToHandle = [
                //     ModelNotFoundException::class,
                //     AuthenticationException::class,
                //     AuthorizationException::class,
                //     QueryException::class,
                //     BadRequestHttpException::class,
                //     NotFoundHttpException::class,
                //     MethodNotAllowedHttpException::class,
                //     HttpException::class,
                //     FileNotFoundException::class,
                //     TooManyRequestsHttpException::class,
                //     ServiceUnavailableHttpException::class,
                // ];


                // if (in_array(get_class($exception), $exceptionTypesToHandle)) {
                //     return $this->apiException($request, $exception);
                // }


                $exceptionHandlers = [
                    ModelNotFoundException::class => "resource_not_found",
                    AuthenticationException::class => "unauthorized_access",
                    AuthorizationException::class => "permission_denied",
                    QueryException::class => "query_execution_error",
                    BadRequestHttpException::class => "bad_request",
                    NotFoundHttpException::class => "route_not_found",
                    MethodNotAllowedHttpException::class => "method_not_allowed",
                    HttpException::class => "access_forbidden",
                    FileNotFoundException::class => "file_not_found",
                    TooManyRequestsHttpException::class => "rate_limit_exceeded",
                    ServiceUnavailableHttpException::class => "service_unavailable",
                    RelationNotFoundException::class => "relation_not_found",
                    ThrottleRequestsException::class => "throttle",
                    // Spatie exceptions
                    RoleDoesNotExist::class => "role_does_not_exist",
                    UnauthorizedException::class => "unauthorized_access",
                ];

                $exceptionType = get_class($exception);

                if (in_array($exceptionType, array_keys($exceptionHandlers))) {
                    $messageKey = $exceptionHandlers[$exceptionType];
                    // return $this->createLog($exception, $messageKey);


                    Log::channel('applicationLog')->error(
                        'Exception : ' . get_class($exception) . PHP_EOL . $exception->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName() . ' Action : ' . Route::currentRouteAction() . ' File : ' . $exception->getFile() . ' at Line N° ' . $exception->getLine()
                    );

                    return response()->json([
                        'status' => false,
                        'message' => trans('exception-errors.' . $messageKey)
                    ]);
                }
            }
        });
    }
}
