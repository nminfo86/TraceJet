<?php

namespace App\Http\Controllers;

use PDOException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AccessTokensRequest;
use App\Http\Controllers\Api\v1\AccessTokensController;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Psr7\Request;

class WebAuthController extends AccessTokensController
{

    /* this function is used to authenticate user with session and to get token */

    public function webLogin(AccessTokensRequest $request)
    {
        try {
            DB::connection()->getPdo();
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                $content = $this->login($request)->getContent();
                $response = json_decode($content, true);
                /* if faild to login in api so logout from web */
                if ($response["status"] == false) {
                    Session::flush();
                    Auth::guard('web')->logout();
                    Auth::guard('sanctum')->guest();
                    return redirect("/")->with('error', $response["message"]);
                }
                $request->session()->put('token', $response['token']);
                $request->session()->put('user_data', $response['data']);
                /* redirect posts to there url */
                if (request()->ip() == "127.0.0.1") {
                    return redirect("/serial_numbers");
                } else if (request()->ip() == "192.168.100.3") {
                    return redirect()->intended("/users");
                }
                return redirect()->intended('/dashboard');
            }
            return redirect("/")->with('error', "les informations d'authentification ne sont pas valides");
        } catch (\Exception $e) {
            return redirect("/")->with('error', "Etat 2002 du serveur");
        }
    }

    public function webLogout()
    {
        Session::flush();
        $deletedRows = DB::table('personal_access_tokens')
            ->where('tokenable_id', Auth::user()->id)
            ->delete();
        Auth::guard('web')->logout();
        Auth::guard('sanctum')->guest();
        return redirect('/');
    }
}
