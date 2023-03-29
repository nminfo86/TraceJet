<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Post;
use App\Models\Movement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // Get last movement of QR and create movement or packaging action
        $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr',  $request->qr)
            ->latest("movements.created_at")
            ->first(['movement_post_id', 'result', 'serial_number']);
        // Not exist
        if (!$product) {
            //Send response with error
            return $this->sendResponse('Product does not belong to the current OF', status: false);
        }

        // Get current post information by mac_address for check previous post
        $post = Post::whereMac($request->mac)->first();
        if (!$post) {
            //Send response with error
            return $this->sendResponse('Check post order', status: false);
        }

        // movement exist with this post
        if ($product->movement_post_id == $post->previous_post_id) {
            //Send response with data
            return $this->sendResponse(data: $product, status: true);
        }
        if ($product->movement_post_id == $post->id) {
            //Send response with error
            return $this->sendResponse('Product already executed on this post', status: false);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}