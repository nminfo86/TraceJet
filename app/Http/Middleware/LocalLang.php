<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocalLang
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
        // app()->setLocale("en");
        // if ($request->lang) {
        //     app()->setLocale($request->lang);
        // }

        app()->setLocale("en");
        if ($request->header('Accept-Language')) {
            // app()->setLocale($request->lang);
            $language = $request->header('Accept-Language');
            app()->setLocale($language);
        } else app()->setLocale("en");
        return $next($request);
    }
}
