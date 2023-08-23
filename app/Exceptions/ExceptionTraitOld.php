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
    public function apiException($request, $e)
    {
        if ($this->isModelNotFound($e)) {
            return $this->modelNotFoundResponse($e);
        }

        if ($this->isAuthentication($e)) {
            return $this->authenticationResponse($e);
        }

        if ($this->isAuthorization($e)) {
            return $this->authorizationResponse($e);
        }

        if ($this->isQuery($e)) {
            return $this->queryResponse($e);
        }

        if ($this->isBadRequestHttp($e)) {
            return $this->badRequestHttpResponse($e);
        }
        // if ($this->isHttp($e)) {
        //     return $this->HttpResponse($e);
        // }
        // if ($this->isMethod($e)) {
        //     return $this->MethodResponse($e);
        // }

        // if ($this->isUnauthorized($e)) {
        //     return $this->UnauthorizedResponse($e);
        // }
        // if ($this->isError($e)) {
        //     return $this->ErrorResponse($e);
        // }
        // if ($this->isBadMethodCall($e)) {
        //     return $this->BadMethodCallResponse($e);
        // }


        return parent::render($request, $e);
        // return true;
    }


    protected function isModelNotFound($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isAuthentication($e)
    {
        return $e  instanceof AuthenticationException;
    }

    protected function isAuthorization($e)
    {
        return $e instanceof AuthorizationException;
    }

    protected function isQuery($e)
    {
        return $e instanceof QueryException;
    }

    protected function isBadRequestHttp($e)
    {
        return $e instanceof BadRequestHttpException;
    }

    protected function isNotFoundHttp($e)
    {
        return $e instanceof NotFoundHttpException;
    }
    protected function isMethodNotAllowedHttp($e)
    {
        return $e instanceof MethodNotAllowedHttpException;
    }

    protected function isHttp($e)
    {
        return $e instanceof HttpException;
    }

    protected function isFileNotFound($e)
    {
        return $e instanceof FileNotFoundException;
    }

    protected function isTooManyRequestsHttp($e)
    {
        return $e instanceof TooManyRequestsHttpException;
    }

    protected function isServiceUnavailableHttp($e)
    {
        return $e instanceof  ServiceUnavailableHttpException;
    }

    // protected function isMethod($e)
    // {
    //     return $e instanceof MethodNotAllowedHttpException;
    // }

    // protected function isError($e)
    // {
    //     return $e instanceof ErrorException;
    // }
    // protected function isBadMethodCall($e)
    // {
    //     return $e instanceof BadMethodCallException;
    // }


    private function createLog($e)
    {
        return Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName()  . ' Action : ' .  Route::currentRouteAction() . ' File : ' . $e->getFile() . ' at Line N° ' . $e->getLine());
    }
    /* -------------------------------------------------------------------------- */
    /*                                  Responses                                 */
    /* -------------------------------------------------------------------------- */

    protected function modelNotFoundResponse($e, $msgKey)
    {
        $this->createLog($e);

        return response()->json(
            [
                'status' => false,
                'message' => trans('exception-errors.resource_not_found')
            ]
        );
    }


    protected function authenticationResponse($e)
    {
        $this->createLog($e);

        return response()->json(
            [
                'status' => false,
                'message' => trans('exception-errors.unauthorized_access')
            ]
        );
    }

    protected function authorizationResponse($e)
    {
        $this->createLog($e);

        return response()->json(
            [
                'status' => false,
                'message' => trans('exception-errors.permission_denied')
            ]
        );
    }

    protected function queryResponse($e)
    {
        $this->createLog($e);

        return response()->json(
            [
                'status' => false,
                'message' => trans('exception-errors.query_execution_error')
            ]
        );
    }

    protected function badRequestHttpResponse($e)
    {
        $this->createLog($e);

        return response()->json(
            [
                'status' => false,
                'message' => trans('exception-errors.bad_request')
            ]
        );
    }
    // protected function HttpResponse($e)
    // {
    //     Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName());

    //     //Send response with success
    //     $msg = $this->getResponseMessage("not_found", ['attribute' => 'modal']);
    //     // return $this->sendResponse($msg, $caliber);
    //     return response()->json(
    //         [
    //             'status' => false,
    //             'message' => $msg
    //         ]
    //         // , Response::HTTP_NOT_FOUND
    //     );
    // }
    // protected function MethodResponse($e)
    // {
    //     Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName());
    //     return response()->json(
    //         [
    //             'status' => false,
    //             'message' => 'The specified method for the request is invalid'
    //         ]
    //         // , Response::HTTP_NOT_FOUND
    //     );
    // }
    // protected function ErrorResponse($e)
    // {

    //     Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName()  . ' Action : ' .  Route::currentRouteAction() . ' File : ' . $e->getFile() . ' at Line N° ' . $e->getLine());


    //     return response()->json(
    //         [
    //             'status' => false,
    //             'message' => 'Error'
    //         ]
    //         // , Response::HTTP_NOT_FOUND
    //     );
    // }



    // protected function BadMethodCallResponse($e)
    // {
    //     Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName()  . ' Action : ' .  Route::currentRouteAction());

    //     return response()->json(
    //         [
    //             'status' => false,
    //             'message' => 'Error'
    //         ]
    //         // , Response::HTTP_NOT_FOUND
    //     );
    // }

    // protected function UnauthorizedResponse($e)
    // {
    //     return response()->json(
    //         [
    //             'status' => false,
    //             'message' => $e->getMessage()
    //         ]
    //         // , Response::HTTP_NOT_FOUND
    //     );
    // }
}
