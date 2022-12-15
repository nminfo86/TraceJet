<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\PostsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostsTypeRequest;

class PostsTypeController extends Controller
{



    function __construct()
    {
        $this->middleware('permission:posts_type-list', ['only' => ['index']]);
        $this->middleware('permission:posts_type-create', ['only' => ['store']]);
        $this->middleware('permission:posts_type-edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:posts_type-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts_type = PostsType::get();

        //Send response with success
        return $this->sendResponse(data: $posts_type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $posts_type = PostsType::create($request->all());

        //Send response with success
        return $this->sendResponse("Created successfully", $posts_type);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostsType $posts_type
     * @return \Illuminate\Http\Response
     */
    public function show(PostsType $posts_type)
    {
        //Send response with success
        return $this->sendResponse(data: $posts_type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostsType $posts_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostsType $posts_type)
    {
        $posts_type->update($request->all());

        //Send response with success
        return $this->sendResponse("Updated successfully", $posts_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostsType $posts_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostsType $posts_type)
    {
        $posts_type->delete();

        //Send response with success
        return $this->sendResponse("Deleted successfully");
    }
}
