<?php

namespace App\Http\Controllers\Api\v1;






use PDOException;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AccessTokensRequest;


class AccessTokensController extends Controller
{
    use ResponseTrait;

    public function login(AccessTokensRequest $request)
    {
        // Attempt to authenticate user with given credentials
        // if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        //     // Return error response if authentication fails
        //     return $this->sendResponse('Username & Password does not match with our record.', status: false);
        // }

        // // Retrieve authenticated user
        // $user = Auth::user();
        // // $user = Auth::user()->makeHidden('permissions', 'roles');

        // // Get device name or user agent from request
        // $device_name = $request->post('device_name', $request->userAgent());

        // // Add permissions to user
        // $user['permission'] =  $user->getPermissionsViaRoles()->pluck('name');

        // // Check for the device being used
        // $user['post_information'] =  Post::whereIpAddress($request->ip())->first() ?? [];

        // if (empty($user['post_information']))
        //     return $this->sendResponse("Invalid host, please contact the system administrator", status: false);
        // $data = [
        //     'token' => $user->createToken($device_name)->plainTextToken,
        //     'data' => $user,
        //     'status' => true
        // ];
        // //  Send Response with data
        // return response($data);

        /* -------------------------------------------------------------------------- */
        /*                                  New Code                                  */
        /* -------------------------------------------------------------------------- */
        // Retrieve post information for user's IP address
        $post_information = Post::whereIpAddress($request->ip())->first();

        // Return error response if post information is not found
        if (empty($post_information)) {

            $msg = $this->getResponseMessage("invalid_host");
            return $this->sendResponse($msg, status: false);
        }

        // Attempt to authenticate user with given credentials
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // $this->logout();
            // TODO::Translate msg
            // Return error response if authentication fails
            return $this->sendResponse('Username & Password does not match with our record.', status: false);
        }

        // Retrieve authenticated user with their roles and permissions
        $user = Auth::user()->load('roles.permissions');
        // Get device name or user agent from request
        $device_name = $request->post('device_name', $request->userAgent());

        // Add user's permissions to response data
        $user['permissions'] = $user->roles->flatMap->permissions->pluck('name')->unique()->toArray();

        // TODO:: remove it later ness it on operator posts in footer
        $user['post_information'] = $post_information;

        // Create token for user and return response with token and user data
        $token = $user->createToken($device_name)->plainTextToken;

        // Storing an array in the session
        Session::put('post_information',  $post_information);
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
        try {
            // Get the authenticated user
            $user = Auth::guard('sanctum')->user();

            // delete the current token that was used for the request
            $user->currentAccessToken()->delete();

            // Destroy the cache associated with the user's session
            Cache::forget('posts_list');

            //  Send Response with success
            return $this->sendResponse();
        } catch (PDOException $e) {
            return $this->CatchExeption($e);
        }
    }
}
