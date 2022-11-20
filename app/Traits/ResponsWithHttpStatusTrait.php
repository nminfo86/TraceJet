<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


trait ResponsWithHttpStatusTrait
{

    protected function CatchExeption($e)
    {
        Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName());
        // return $e->getMessage();
        //Prepare message for translation
        // $message = trans('ajax.error', ['stackTrace' => Route::currentRouteName()]);

        // return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);

        die($e->getMessage());
    }



    protected function successResponse($message, $status = 200)
    {
        return response([
            'success' => true,
            'message' => $message,
        ], $status);
    }

    protected function errorResponse($message = "", $status = 404)
    {
        return response([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    protected function dataResponse($data, $status = 200)
    {
        return response($data, $status);
    }
}