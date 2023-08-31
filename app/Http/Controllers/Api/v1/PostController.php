<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Post;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StorePostRequest;
use App\Http\Requests\UpdateRequests\UpdatePostRequest;

class PostController extends Controller
{
    use ResponseTrait;
    function __construct()
    {
        $this->middleware('permission:post-list', ['only' => ['index']]);
        $this->middleware(['permission:post-create', 'permission:post-list'], ['only' => ['store']]);
        $this->middleware('permission:post-edit', ['only' => ['show', 'update']]);
        $this->middleware(['permission:post-delete', 'permission:post-list'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::leftJoin('posts as a', 'posts.previous_post_id', '=', 'a.id')
            ->join('sections', 'posts.section_id', '=', 'sections.id')
            ->join('posts_types', 'posts.posts_type_id', '=', 'posts_types.id')
            ->leftJoin('printers', 'posts.printer_id', '=', 'printers.id')
            ->get(['posts.id', 'posts.code', 'posts.post_name', 'posts_types.posts_type', 'sections.section_name', 'posts.ip_address', 'a.post_name as previous_post', 'posts.color', 'printers.name as printer_name']);
        // dd($posts);
        //Send response with success
        return $this->sendResponse(data: $posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->all());

        //Send response with success
        $msg = __("response-messages.success");
        return $this->sendResponse($msg, $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //Send response with success
        return $this->sendResponse(data: $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());

        //Send response with success
        $msg = __("response-messages.success");
        return $this->sendResponse($msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        //Send response with success
        $msg = __("response-messages.success");
        return $this->sendResponse($msg);
    }

    public function getCurrentPost($ip)
    {
        return Post::whereMac($ip)->firstOrFail();
    }
}
