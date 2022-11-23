<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Error;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
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
        if ($this->isError($e)) {
            return $this->QueryResponse($e);
        }

        return parent::render($request, $e);
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
    protected function isError($e)
    {
        return $e instanceof Error;
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
        return response()->json(
            [
                'status' => false,
                'errors' => $e->getMessage()
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
}