<?php

namespace App\Exceptions;

use Error;
use ErrorException;
use BadMethodCallException;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait ExceptionTrait
{
    use ResponseTrait;
    public function apiException($request, $e)
    {
        if ($this->isModel($e)) {
            return $this->ModelResponse($e);
        }

        if ($this->isHttp($e)) {
            return $this->HttpResponse($e);
        }
        if ($this->isMethod($e)) {
            return $this->MethodResponse($e);
        }
        if ($this->isQuery($e)) {
            return $this->QueryResponse($e);
        }
        if ($this->isUnauthorized($e)) {
            return $this->UnauthorizedResponse($e);
        }
        if ($this->isError($e)) {
            return $this->ErrorResponse($e);
        }
        if ($this->isBadMethodCall($e)) {
            return $this->BadMethodCallResponse($e);
        }

        return parent::render($request, $e);
        // return true;
    }


    protected function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isHttp($e)
    {
        return $e instanceof NotFoundHttpException;
    }
    protected function isMethod($e)
    {
        return $e instanceof MethodNotAllowedHttpException;
    }
    protected function isQuery($e)
    {
        return $e instanceof QueryException;
    }
    protected function isUnauthorized($e)
    {
        return $e instanceof UnauthorizedException;
    }
    protected function isError($e)
    {
        return $e instanceof ErrorException;
    }
    protected function isBadMethodCall($e)
    {
        return $e instanceof BadMethodCallException;
    }



    protected function ModelResponse($e)
    {
        return response()->json(
            [
                'status' => false,
                'errors' => 'Model not found'
            ]
            // , Response::HTTP_NOT_FOUND
        );
    }

    protected function HttpResponse($e)
    {
        Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName());
        return response()->json(
            [
                'status' => false,
                'errors' => 'Not found'
            ]
            // , Response::HTTP_NOT_FOUND
        );
    }
    protected function MethodResponse($e)
    {
        return response()->json(
            [
                'status' => false,
                'errors' => 'The specified method for the request is invalid'
            ]
            // , Response::HTTP_NOT_FOUND
        );
    }
    protected function ErrorResponse($e)
    {

        Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName()  . ' Action : ' .  Route::currentRouteAction() . ' File : ' . $e->getFile() . ' at Line N° ' . $e->getLine());


        return response()->json(
            [
                'status' => false,
                'errors' => 'Error'
            ]
            // , Response::HTTP_NOT_FOUND
        );
    }


    protected function QueryResponse($e)
    {
        Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName()  . ' Action : ' .  Route::currentRouteAction());

        return response()->json(
            [
                'status' => false,
                'errors' => 'Error code ' . $e->getCode()
            ]
            // , Response::HTTP_NOT_FOUND
        );
    }
    protected function BadMethodCallResponse($e)
    {
        Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName()  . ' Action : ' .  Route::currentRouteAction());

        return response()->json(
            [
                'status' => false,
                'errors' => 'Error'
            ]
            // , Response::HTTP_NOT_FOUND
        );
    }

    protected function UnauthorizedResponse($e)
    {
        return response()->json(
            [
                'status' => false,
                'errors' => $e->getMessage()
            ]
            // , Response::HTTP_NOT_FOUND
        );
    }
}