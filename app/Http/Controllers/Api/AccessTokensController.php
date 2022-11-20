<?php

namespace App\Http\Controllers\Api;

use PDOException;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Requests\AccessTokensRequest;
use App\Traits\ResponsWithHttpStatusTrait;

// [x]:Create trait for response json type
// [ ]:Get the team's opinion about all responses status code
class AccessTokensController extends Controller
{
    use ResponsWithHttpStatusTrait;

    public function login(AccessTokensRequest $request)
    {
        try {

            $user = User::where('username', $request->username)->first();
            if ($user && Hash::check($request->password, $user->password)) {

                // set device name
                $device_name = $request->post('device_name', $request->userAgent());

                // Create token
                $token = $user->createToken($device_name)->plainTextToken;

                //  Return Response with success
                return $this->dataResponse(['token' => $token], 201);
            }

            # Return Response with error
            return $this->errorResponse('Username or password is incorrect please try again');
        } catch (PDOException $e) {
            return $this->CatchExeption($e);
        }
    }

    public function destroy($token = null)
    {
        try {
            // Get the authenticated user
            $user = Auth::guard('sanctum')->user();

            // Revoke current token
            if ($token == null) {
                $user->currentAccessToken()->delete();

                //  Return Response with success
                return $this->successResponse('Current Token destroyed');
            }

            // [ ]:Get the team's opinion about Revoke specified token

            $personal_access_token = PersonalAccessToken::findToken($token);

            // Check token exist and related for same authenticated user
            if ($personal_access_token && $user->id == $personal_access_token->tokenable_id && get_class($user) == $personal_access_token->tokenable_type) {

                // Revoke specified token
                $personal_access_token->delete();

                //  Return Response with success
                return $this->successResponse('This Token ' . $token . 'is destroyed');
            }

            // Return Response with error
            return $this->errorResponse("invalid token");
        } catch (PDOException $e) {
            return $this->CatchExeption($e);
        }
    }

    public function destroyAll()
    {
        $user = Auth::guard('sanctum')->user();

        # Revoke all tokens example (logout from all device)

        #Tokens is relation between table personal_access_tokens & user one to many define in Has_Api_token trait
        $tokens = $user->tokens()->delete();
        if ($tokens) {
            return $this->successResponse('Logout user from all devices');
        }
        return $this->errorResponse();
    }
}