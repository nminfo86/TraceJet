<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Post;
use App\Models\Movement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\MovementService;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $post = Post::whereMac($request->mac)->first();

        $last_movement = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->join('ofs', 'serial_numbers.of_id', 'ofs.id')
            ->join('calibers', 'ofs.caliber_id', 'calibers.id')
            ->where('serial_numbers.qr',  $request->qr)
            //    todo::fixme
            // ->where('ofs.status', "inProd")
            ->latest("movements.created_at")->first(['movement_post_id', 'serial_numbers.of_id', 'qr', 'serial_number_id', 'result', 'caliber_name', 'box_quantity', 'serial_numbers.serial_number']);
        if (!$last_movement) {
            //Send response with error
            return $this->sendResponse('The product does not belong to the current manufacturing order', status: false);
        } else if ($last_movement->movement_post_id == $post->previous_post_id) {
            return $last_movement;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MovementService $movementService)
    {
        return $movementService->productStepsControl($request, $request);
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
