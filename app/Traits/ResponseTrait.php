<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


trait ResponseTrait
{

    // protected function CatchExeption($e)
    // {
    //     Log::channel('applicationLog')->error($e->getMessage() . PHP_EOL . ' at : ' . Route::currentRouteName());
    //     // // return $e->getMessage();
    //     // //Prepare message for translation
    //     // $message = ['stackTrace' => Route::currentRouteName()];
    //     // return $this->returnResponse($message, status: false);
    //     // // return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
    //     // return response()->json(['status' => 'failed', 'message' => $message]);

    //     die($e->getMessage());
    // }
}