<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


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


    public $success_msg = "Created successfully";
}