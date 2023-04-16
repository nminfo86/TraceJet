<?php

namespace App\Http\Controllers\api\v1;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Movement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OperatorController extends Controller
{
    //TODO::common functions
    /**
     * Get current post information.
     *
     * @param  $mac_address from request
     * @return \Illuminate\Http\Response
     */
    /** checkProductSteps void */
    public function getCurrentPostInformation(string $mac_address)
    {
        // FIXME::change mac by ip address
        $post = Post::whereMac($mac_address)->first();
        return $post ?? false;
    }

    //TODO::common functions

    /**
     * checkProductSteps void
     *
     * @param  mixed $request  [mac_address,new result]
     * @param  mixed $last_movement [movement_post_id,result]
     * @return \Illuminate\Http\Response
     */

    /** checkProductSteps void */
    public function checkProductSteps($request,  $last_movement)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $qr_operator_list['list'] = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.of_id', $request->of_id)
            ->where('movements.movement_post_id', $request->host_id)
            ->get(["serial_number", "movements.created_at", "movements.result"]);

        // Get quantity of valid product (TODAY)
        $qr_operator_list['quantity_of_day'] = "0" . $qr_operator_list['list']->filter(function ($item) {
            return date('Y-m-d', strtotime($item['created_at'])) == Carbon::today()->toDateString();
        })->count();
        // $qr_operator_list['post_name'] = $request->host_name;
        return $this->sendResponse(data: $qr_operator_list);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */

    /* @var checkProductSteps void */
    public function store(Request $request)
    {
        // check movement
        $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr',  $request->qr)
            ->where('serial_numbers.of_id', $request->of_id)
            ->latest("movements.created_at")
            ->first(['serial_numbers.id AS sn_id', 'movement_post_id', 'result']);


        // Check & control product steps error
        $checkProductSteps = $this->productService->checkProductSteps($request, $product)->getData();


        if (!isset($checkProductSteps->data)) {
            return $checkProductSteps;
        }


        // Prepare payload
        $payload = [
            'serial_number_id' => $product->sn_id,
            'movement_post_id' => $checkProductSteps->data->current_post_id,
            'result' => $request->result,
        ];

        // Create new movement
        $movement = Movement::create($payload);

        //Send response with success
        return $this->sendResponse($this->create_success_msg, $movement);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @var void $checkProductSteps
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Get last movement of QR
        $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr',  $request->qr)
            ->where('serial_numbers.of_id', $request->of_id)
            ->latest("movements.created_at")
            ->first(['movement_post_id', 'result', 'serial_number']);

        // Check & control product steps error (if not exist current_post_id thats mean there is un error)
        return $this->productService->checkProductSteps($request,  $product);
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
