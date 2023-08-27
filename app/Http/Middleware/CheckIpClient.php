<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// TODO::change name of class
class CheckIpClient
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, Int $post_type)
    {

        // FIXME::with samir later
        // $post = Post::where("section_id", Auth::user()->section_id)->where("ip_address", $request->ip())->where('posts_type_id', $post_type)->first();
        $post = Post::where([
            ["section_id", Auth::user()->section_id],
            ["ip_address", $request->ip()],
            ['posts_type_id', $post_type]
        ])->first();


        if ($request->ajax()) {
            // if (!$post && Auth::user()->roles_name != "super_admin") {
            if (!$post && !Auth::user()->hasPermissionTo('access-all-posts')) {
                // Code to execute if the collection contains an item with posts_type_id = 1
                // $result =  ['message' => 'No matching host found. Please contact the administrator.', "status" => false];
                // return response()->json($result);
                $msg = __("response-messages.invalid_host");

                return $this->sendResponse($msg, status: false);
            }
            //  elseif (Auth::user()->hasPermissionTo('access-all-posts')) {
            //     $msg = "Admin can not be ion Production chaine";

            //     return $this->sendResponse($msg, status: false);
            // }
        } else {
            if (!$post)
                return redirect("/")->with('error', __("response-messages.invalid_host"));
        }

        // }
        return $next($request);
    }
}
