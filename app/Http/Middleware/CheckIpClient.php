<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Post;
use Illuminate\Http\Request;

class CheckIpClient
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
        $ip = request()->ip();

        // if ($ip == '192.168.100.3') {
        //     // If user is super-admin, accept the request
        //     return $next($request);
        // }
        if ($ip == '192.168.100.5' || $ip = "192.168.100.3") {
            // If user is super-admin, accept the request
            return $next($request);
        }
        // If user does not have the super-admin role redirect them to another page that isn't restricted
        return redirect('/');
    }
}