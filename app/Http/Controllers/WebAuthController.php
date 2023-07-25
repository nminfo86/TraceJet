<?php

namespace App\Http\Controllers;

use PDOException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AccessTokensRequest;
use App\Http\Controllers\Api\v1\AccessTokensController;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Request;

class WebAuthController extends AccessTokensController
{

    /* this function is used to authenticate user with session and to get token */

    public function webLogin(AccessTokensRequest $request)
    {
        try {
            // Check database connection
            DB::connection()->getPdo();

            // Make the login request and get the response
            $response = json_decode($this->login($request)->getContent(), true);

            if ($response["status"] === false) {
                // If login fails, redirect back with error message
                return redirect("/login")->with('error', $response["message"]);
            }

            // Determine the client IP address
            $clientIp = Request::ip();

            // Handle redirection based on the client IP address
            if ($clientIp === "10.0.1.201") {
                // Redirect to /serial_numbers if IP is 10.0.0.201
                return redirect("/serial_numbers");
            } elseif ($clientIp === "192.168.100.3") {
                // Redirect to /users if IP is 192.168.100.3
                return redirect()->intended("/users");
            }
            // Default redirection to /dashboard for other IP addresses
            return redirect()->intended('/dashboard');
        } catch (Exception $e) {
            // Handle exception and redirect back with error message
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
        return redirect('/login');
    }
}
