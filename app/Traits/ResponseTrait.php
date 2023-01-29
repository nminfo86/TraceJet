<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


trait ResponseTrait
{
    // Used in success response
    public $create_success_msg = "Created successfully";
    public $update_success_msg = "Updated successfully";
    public $delete_success_msg = "Deleted successfully";

    function sendResponse($message = null, $data = [], $status = true)
    {
        match ($status) {
            false => $response = ["message" => $message],
            !empty($data) && !is_null($message) => $response = ["message" => $message, "data" => $data],
            !empty($data) && is_null($message) => $response = ["data" => $data],
            empty($data) && !is_null($message) => $response = ["message" => $message],
            empty($data) && is_null($message) => null,
        };
        $response['status'] = $status;
        return response()->json($response);
    }
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