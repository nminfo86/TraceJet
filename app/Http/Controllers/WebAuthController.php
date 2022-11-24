<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\AccessTokensController;
use App\Http\Requests\AccessTokensRequest;
use Illuminate\Support\Facades\Auth;
class WebAuthController extends AccessTokensController
{

    /* this function is used to authenticate user with session and to get token */

    public function webLogin(AccessTokensRequest $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $response=$this->login($request);
            $request->session()->put('token',$response['data']['token']);
            return redirect()->intended('/welcome');
        }
       return redirect("/")->with('error','Login details are not valid');
    }
}
