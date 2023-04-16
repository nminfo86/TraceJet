<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


trait ResponseTrait
{

    /**
     * getResponseMessage
     *
     * @param  mixed $key
     * @param  array $replacements list des attributes
     * @return void
     */
    protected function getResponseMessage($key, $replacements = [])
    {
        $messages = [
            //productService
            'not_found' => __('response-messages.not_found'),
            'exists' => __('response-messages.exists'),
            'product_place' => __('response-messages.product_place'),

            // Serialnumber
            'of_closed' => __('response-messages.of_closed'),
            "print_qr-success" => __('response-messages.print_qr-success'),
            // Add more custom messages here
        ];

        $attributes = [
            'product' => __('response-messages.product'),
            'operator 1' => __('response-messages.operator 1'),
            // Add more custom attributes here
        ];

        // Replace placeholders with actual values
        $message = $messages[$key];

        foreach ($replacements as $key => $value) {

            // Translate if the value exists as a key in the array
            if (array_key_exists($value, $attributes)) {
                $message = str_replace(':' . $key, $attributes[$value], $message);
            }
        }

        return ucfirst($message);
    }



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
