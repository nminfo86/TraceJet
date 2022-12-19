<?php

namespace App\Http\Controllers;

use PDOException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AccessTokensRequest;
use App\Http\Controllers\Api\api_v1\AccessTokensController;
use GuzzleHttp\Psr7\Request;

class WebAuthController extends AccessTokensController
{

    /* this function is used to authenticate user with session and to get token */

    public function webLogin(AccessTokensRequest $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $response=$this->login($request);
            $request->session()->put('token',$response['message']['token']);
            return redirect()->intended('/dashboard');
        }
       return redirect("/")->with('error','Login details are not valid');
    }

    public function webLogout()
    {
        Session::flush();
        Auth::guard('web')->logout();
        Auth::guard('sanctum')->guest();
        return redirect('/');
    }
}
