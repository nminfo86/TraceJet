<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Post;
use App\Models\Movement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class MovementController extends Controller
{



    function __construct()
    {
        $this->middleware('permission:movement-list', ['only' => ['index']]);
        $this->middleware('permission:movement-create', ['only' => ['store']]);
        $this->middleware('permission:movement-edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:movement-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movement = Movement::get();

        //Send response with success
        return $this->sendResponse(data: $movement);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  TODO::resolve created_at date problem
        // Get sender post from posts table
        $post = Post::where('mac', $request->mac)->firstOrFail(); // TODO::Change later
        if ($post->previous_post == NULL) {
            //Send response with message
            return $this->sendResponse("Cannot create in this post", status: false);
        }

        // Get last movement of QR
        $qr_movements = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr',  $request->qr)
            ->latest()->first(['movements.id', 'previous_post_id', 'qr', 'serial_number_id', 'result']);

        // Not exist
        if (!$qr_movements) {
            //Send response with error
            return $this->sendResponse('QR does not belong to the current OF', status: false);
        } else {

            if ($qr_movements->previous_post_id == $post->id) {

                //Send response with error
                return $this->sendResponse('QR has been already exists', status: false);
            }

            // Check result
            if ($qr_movements->result !== 'ok') {

                //Send response with error
                return $this->sendResponse('Transfer to repairer', status: false);
            }  // // Check Post order
            if ($qr_movements->previous_post_id != $post->previous_post) {

                //Send response with error
                return $this->sendResponse('Check posts order', status: false);
            }
        }

        // Prepare movement inputs
        $inputs = [
            'serial_number_id'      => $qr_movements->serial_number_id,
            'previous_post_id'      => $post->id,
            // 'previous_post_name'    => $post->post,
            'result'                => $request->only('result')['result']
        ];

        // Crete new movement
        $movement = Movement::create($inputs);

        //Send response with success
        return $this->sendResponse("Created successfully", $movement);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movement $movement
     * @return \Illuminate\Http\Response
     */
    public function show(Movement $movement)
    {
        //Send response with success
        return $this->sendResponse(data: $movement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movement $movement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movement $movement)
    {
        $movement->update($request->all());

        //Send response with success
        return $this->sendResponse("Updated successfully", $movement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movement $movement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movement $movement)
    {
        $movement->delete();

        //Send response with success
        return $this->sendResponse("Deleted successfully");
    }
}