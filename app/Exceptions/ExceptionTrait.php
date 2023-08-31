<?php

namespace App\Exceptions;

use Error;
use ErrorException;
use BadMethodCallException;
// use App\Traits\ResponseTrait;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

trait ExceptionTrait
{
    use ResponseTrait;
    // public function apiException($request, $e)
    // {
    //     // Check for specific exception types and handle them
    //     if ($this->isModelNotFound($e)) {
    //         return $this->createLog($e, "resource_not_found");
    //     } elseif ($this->isAuthentication($e)) {
    //         return $this->createLog($e, "unauthorized_access");
    //     } elseif ($this->isAuthorization($e)) {
    //         return $this->createLog($e, "permission_denied");
    //     } elseif ($this->isQuery($e)) {
    //         return $this->createLog($e, "query_execution_error");
    //     } elseif ($this->isBadRequestHttp($e)) {
    //         return $this->createLog($e, "bad_request");
    //     } elseif ($this->isNotFoundHttp($e)) {
    //         return $this->createLog($e, "route_not_found");
    //     } elseif ($this->isMethodNotAllowedHttp($e)) {
    //         return $this->createLog($e, "method_not_allowed");
    //     } elseif ($this->isHttp($e)) {
    //         return $this->createLog($e, "access_forbidden");
    //     } elseif ($this->isFileNotFound($e)) {
    //         return $this->createLog($e, "file_not_found");
    //     } elseif ($this->isTooManyRequestsHttp($e)) {
    //         return $this->createLog($e, "rate_limit_exceeded");
    //     } elseif ($this->isServiceUnavailableHttp($e)) {
    //         return $this->createLog($e, "service_unavailable");
    //     }

    //     // If no specific exception type matches, use default error handling
    //     return parent::render($request, $e);
    // }

    // /* -------------------------------------------------------------------------- */
    // /*                           Exception Type Checks                            */
    // /* -------------------------------------------------------------------------- */

    // protected function isModelNotFound($e)
    // {
    //     return $e instanceof ModelNotFoundException;
    // }

    // protected function isAuthentication($e)
    // {
    //     return $e instanceof AuthenticationException;
    // }

    // protected function isAuthorization($e)
    // {
    //     return $e instanceof AuthorizationException;
    // }

    // protected function isQuery($e)
    // {
    //     return $e instanceof QueryException;
    // }

    // protected function isBadRequestHttp($e)
    // {
    //     return $e instanceof BadRequestHttpException;
    // }

    // protected function isNotFoundHttp($e)
    // {
    //     return $e instanceof NotFoundHttpException;
    // }

    // protected function isMethodNotAllowedHttp($e)
    // {
    //     return $e instanceof MethodNotAllowedHttpException;
    // }

    // protected function isHttp($e)
    // {
    //     return $e instanceof HttpException;
    // }

    // protected function isFileNotFound($e)
    // {
    //     return $e instanceof FileNotFoundException;
    // }

    // protected function isTooManyRequestsHttp($e)
    // {
    //     return $e instanceof TooManyRequestsHttpException;
    // }

    // protected function isServiceUnavailableHttp($e)
    // {
    //     return $e instanceof ServiceUnavailableHttpException;
    // }

    // /* -------------------------------------------------------------------------- */
    // /*                               Logging Function                             */
    // /* -------------------------------------------------------------------------- */

    // private function createLog($e, $msgKey)
    // {
    //     // Log exception details and create a JSON response
    //     Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL .
    //         ' at : ' . Route::currentRouteName() . ' Action : ' . Route::currentRouteAction() .
    //         ' File : ' . $e->getFile() . ' at Line N° ' . $e->getLine());

    //     return response()->json([
    //         'status' => false,
    //         'message' => trans('exception-errors.' . $msgKey)
    //     ]);
    // }


    // public function apiException($request, $e, $msgKey)
    // {
    //     return $this->createLog($e, $msgKey);
    //     // dd($msgKey);
    //     // $exceptionHandlers = [
    //     //     ModelNotFoundException::class => "resource_not_found",
    //     //     AuthenticationException::class => "unauthorized_access",
    //     //     AuthorizationException::class => "permission_denied",
    //     //     QueryException::class => "query_execution_error",
    //     //     BadRequestHttpException::class => "bad_request",
    //     //     NotFoundHttpException::class => "route_not_found",
    //     //     MethodNotAllowedHttpException::class => "method_not_allowed",
    //     //     HttpException::class => "access_forbidden",
    //     //     FileNotFoundException::class => "file_not_found",
    //     //     TooManyRequestsHttpException::class => "rate_limit_exceeded",
    //     //     ServiceUnavailableHttpException::class => "service_unavailable",
    //     // ];

    //     // foreach ($exceptionHandlers as $exceptionType => $msgKey) {
    //     //     if ($e instanceof $exceptionType) {
    //     //         return $this->createLog($e, $msgKey);
    //     //     }
    //     // }

    //     // return parent::render($request, $e);
    // }


    // /* Exception Type Checks and Logging Function */

    // private function createLog($e, $msgKey)
    // {
    //     // Log exception details and create a JSON response
    //     Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL .
    //         ' at : ' . Route::currentRouteName() . ' Action : ' . Route::currentRouteAction() .
    //         ' File : ' . $e->getFile() . ' at Line N° ' . $e->getLine());

    //     return response()->json([
    //         'status' => false,
    //         'message' => trans('exception-errors.' . $msgKey)
    //     ]);
    // }
}
