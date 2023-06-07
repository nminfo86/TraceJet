<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIpClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, Int $post_type)
    {
        // $lastSegment = $request->segments($request->segments);
        // dd($lastSegment);
        // $url = $request->requestUri();
        // dd($url);
        // $urlWithQueryString = $request->fullUrl();
        // $request->fullUrlWithQuery(['type' => 'phone']);
        // $request->host();
        // // dd($request->segment);
        // $request->httpHost();
        // $request->schemeAndHttpHost();


        // if ($request->url() == "http://localhost:8000/api/v1/pluck/ofs") {

        $posts_list = Post::where("section_id", Auth::user()->section_id)->get();

        $containsTypeId = $posts_list->contains('posts_type_id', $post_type); //1 is label generator

        if (!$containsTypeId) {
            // Code to execute if the collection contains an item with posts_type_id = 1
            $result =  ['message' => 'Invalid host section, you have not a permission', "status" => false];
            return response()->json($result);
        }
        // }
        return $next($request);

        // dd($request->url());
        // $lastSegment = $request->segment($request->segments->count() - 1);

        // dd($lastSegment);
        // $allowedIpAddress = $request->ip();
        // // dd($allowedIpAddress);
        // if ($request->ip() === "127.0.0.1") {
        //     return redirect('dashboard');
        // }
        // return $next($request);

        // if ($ip == '10.159.99.234' || $ip == "10.1.0.1" || "192.168.100.6") {

        //     // If user is super-admin, accept the request
        //     return $next($request);
        // }

        // If user does not have the super-admin role redirect them to another page that isn't restricted
        // return redirect('/');


        // $allowed_ips = [
        //     '127.0.0.1' => 'dashboard',
        //     '10.0.0.2' => 'profile',
        //     '10.0.0.3' => 'settings',
        // ];

        // $ip_address = $request->ip();
        // if (array_key_exists($ip_address, $allowed_ips)) {
        //     $redirect_url = url($allowed_ips[$ip_address]);
        //     return redirect($redirect_url);
        // }

        // return $next($request);
    }
}
