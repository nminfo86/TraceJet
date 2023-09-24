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

        $post = Post::
            // when(!Auth::user()->hasPermissionTo('access-all-posts'), function ($query) {
            //     // If the user doesn't have permission to access all posts,
            //     // apply a constraint based on the user's section_id
            //     return $query->where('section_id', Auth::user()->section_id);
            // })->
            where([
                ['ip_address', request()->ip()],
                ['section_id', Auth::user()->section_id],
                ['posts_type_id', $post_type]
            ])->first();

        if (!$post) {
            $msg = __("response-messages.invalid_host");
            return $this->sendResponse($msg, status: false);
        }

        // get related printer information
        $printer = $post->printer ?? false;





        $request->merge(['host_id' => $post->id, 'previous_post_id' => $post->previous_post_id, 'posts_type' => $post->posts_type_id, "printer" => $printer]);
        // } else {
        //     if (!$post)
        //         return redirect("/logout")->with('error', __("response-messages.invalid_host"));
        // }

        // $request->merge(['host_id' => $post->id, 'previous_post_id' => $post->previous_post_id]);


        // dd($request->host_id);
        return $next($request);
    }
}
