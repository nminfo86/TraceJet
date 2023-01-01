<?php

namespace App\Http\Controllers\Api\v1;






use PDOException;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AccessTokensRequest;

class AccessTokensController extends Controller
{


    public function login(AccessTokensRequest $request)
    {
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

            // # Send Response with error
            return $this->sendResponse('Username & Password does not match with our record.', status: false);
        }
        $user = Auth::user()->makeHidden('permissions', 'roles');
        $device_name =  $request->post('device_name', $request->userAgent());
        $user['permission'] =  $user->getPermissionsViaRoles()->pluck('name');

        $data = [
            'token' => $user->createToken($device_name)->plainTextToken,
            'data' => $user,
            'status' => true
        ];

        return response()->json($data);
        //  Send Response with data
        // return $this->sendResponse(data:$data);
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
