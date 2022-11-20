<?php

namespace App\Http\Middleware;



use Closure;
use Illuminate\Http\Request;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        #x-api-key must be in header of request and should be equal the secret (app-api-key in .env file) for more security
        $token = $request->header('x-api-key');
        if ($token !== config('app.app_api_key')) {
            return Response()->json([
                'message' => 'Invalid Application Key you have not a permission',   #change later
            ], 400);
        }
        return $next($request);
    }
}