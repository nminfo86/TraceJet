<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseTrait;

    // protected function getResponseMessage($key, $replacements = [])
    // {
    //     $messages = [
    //         'not_found' => __('response-messages.not_found'),
    //         'exists' => __('response-messages.exists'),
    //         'product_place' => __('response-messages.product_place'),
    //         // Add more custom messages here
    //     ];

    //     $attributes = [
    //         'product' => __('response-messages.product'),
    //         'operator 1' => __('response-messages.operator 1'),
    //         // Add more custom attributes here
    //     ];

    //     // Replace placeholders with actual values
    //     $message = $messages[$key];

    //     foreach ($replacements as $key => $value) {

    //         // Translate if the value exists as a key in the array
    //         if (array_key_exists($value, $attributes)) {
    //             $message = str_replace(':' . $key, $attributes[$value], $message);
    //         }
    //     }

    //     return ucfirst($message);
    // }

    // // Used in success response
    public $create_success_msg = "Created successfully";
    public $update_success_msg = "Updated successfully";
    public $delete_success_msg = "Deleted successfully";

    // function sendResponse($message = null, $data = [], $status = true)
    // {
    //     match ($status) {
    //         false => $response = ["message" => $message],
    //         !empty($data) && !is_null($message) => $response = ["message" => $message, "data" => $data],
    //         !empty($data) && is_null($message) => $response = ["data" => $data],
    //         empty($data) && !is_null($message) => $response = ["message" => $message],
    //         empty($data) && is_null($message) => null,
    //     };
    //     $response['status'] = $status;
    //     return response()->json($response);
    // }
    /**
     * postsListFromCache
     *
     * @param  int $type
     * @return Objet
     */
    public function postsListFromCache(Int $type)
    {
        $posts_list = Post::where("section_id", Auth::user()->section_id)->get();
        $containsTypeId = $posts_list->contains('posts_type_id', $type); //1 is label generator
        if (!$containsTypeId) {
            // Code to execute if the collection contains an item with posts_type_id = 1
            $result =  ["message" => "Post not exist in your section", "status" => false];
            return $result;
        }
        return true;
    }
}
