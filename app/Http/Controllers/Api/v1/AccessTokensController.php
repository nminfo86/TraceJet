<?php

namespace App\Http\Controllers\Api\v1;

use PDOException;
use App\Models\Post;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AccessTokensRequest;


class AccessTokensController extends Controller
{
    use ResponseTrait;

    public function login(AccessTokensRequest $request)
    {

        // Attempt to authenticate user with given credentials
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // $this->logout();
            // Return error response if authentication fails
            $msg = __("response-messages.credentials_incorrect");
            return $this->sendResponse($msg, status: false);
        }

        $user = Auth::user();
        // $user->setHidden(['roles']); // Hide the roles in the response

        // Add permissions to user
        // $permissions =  $user->getPermissionsViaRoles()->pluck('name');

        // Retrieve post information for user's IP address
        // $post_information = Post::whereIpAddress($request->ip())->whereSectionId($user->section_id)->first();

        // // Return error response if post information is not found
        // if (empty($post_information) && !$permissions->contains("access-all-posts")) {
        //     $msg = __("response-messages.invalid_host");
        //     return $this->sendResponse($msg, status: false);
        // }


        // if ($permissions->contains("access-all-posts")) {
        //     $user->post_information = null;
        // } else {
        //     $user->post_information = $post_information;
        // }
        // Get device name or user agent from request
        $device_name = $request->post('device_name', $request->userAgent() . " with Ip address : " . $request->ip());
        // Create token for user and return response with token and user data
        $token = $user->createToken($device_name)->plainTextToken;

        // Storing an array in the session
        // Session::put('post_information',  $post_information);
        Session::put('token', $token);
        Session::put('user_data', $user);
        $data = [
            'token' => $token,
            'data' => $user,
            'status' => true
        ];
        return response($data);
    }


    public function logout()
    {
        // try {
        // Get the authenticated user
        $user = Auth::guard('sanctum')->user();

        // delete the current token that was used for the request
        $user->currentAccessToken()->delete();

        // Destroy the cache associated with the user's session
        Cache::forget('posts_list');

        //  Send Response with success
        // return $this->sendResponse("LogOut",status:true);
        // } catch (PDOException $e) {
        //     return $this->CatchExeption($e);
        // }
    }
}
