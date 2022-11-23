<?php

namespace App\Http\Controllers\Api\api_v1;

use PDOException;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AccessTokensRequest;

class AccessTokensController extends Controller
{
    use ResponseTrait;

    public function login(AccessTokensRequest $request)
    {
        try {

            if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

                // # Send Response with error
                return $this->sendResponse('Email & Password does not match with our record.', status: false);
            }

            $user = Auth::user();

            // set device name
            $device_name = $request->post('device_name', $request->userAgent());

            $data = [
                'token' => $user->createToken($device_name)->plainTextToken, // Create token
                'user' => $user
            ];

            //  Send Response with success
            return $this->sendResponse("User login successfully.", $data);
        } catch (PDOException $e) {
            return $this->CatchExeption($e);
        }
    }

    public function logout()
    {
        try {
            // Get the authenticated user
            $user = Auth::guard('sanctum')->user();

            // delete the current token that was used for the request
            $user->currentAccessToken()->delete();

            //  Send Response with success
            return $this->sendResponse();
        } catch (PDOException $e) {
            return $this->CatchExeption($e);
        }
    }
}