<?php

namespace App\Http\Controllers\api\v1;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use Mockery\Undefined;
use App\Models\Movement;
use Hamcrest\Core\IsTypeOf;
use App\Models\SerialNumber;
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
    public function getCurrentPostInformation(string $mac_address)
    {
        // FIXME::change mac by ip address
        $post = Post::whereMac($mac_address)->first();
        return $post ?? false;
    }

    //TODO::common functions

    /**
     * checkProductSteps
     *
     * @param  mixed $request  [mac_address,new result]
     * @param  mixed $last_movement [movement_post_id,result]
     * @return void
     */
    public function checkProductSteps($request,  $last_movement)
    {
        // Check existence of product in current OF
        if (!$last_movement) {
            //Send response with error
            return $this->sendResponse('Product does not belong to the current OF', status: false);
        }

        // Get current post information by mac_address ==>ip address for check previous post
        $current_post = $this->getCurrentPostInformation($request->mac);

        if (!$current_post) {
            //Send response with
            return $this->sendResponse('Invalid post', status: false);
        }

        // Verify that the product has passed on this post
        if ($last_movement->movement_post_id == $current_post->id) {
            //Send response with error
            return $this->sendResponse('Product passed on this post ', status: false);
        }
        // Get the name of last movement post
        $post_name = Post::findOrFail($last_movement->movement_post_id)->post_name;


        // Check last movement
        if ($last_movement->movement_post_id != $current_post->previous_post_id) {
            //Send response with error
            return $this->sendResponse("Last station was on , $post_name", status: false);
        }

        // Check result of last movement
        if ($last_movement->result == 'NOK') {
            //Send response with error
            return $this->sendResponse("Product invalid on , $post_name", status: false);
        }

        // Add current post_id to response
        $last_movement->current_post_id = $current_post->id;

        return $last_movement;
        //Send response with data
        // return $this->sendResponse(data:$last_movement,status:true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $current_post_id = $this->getCurrentPostInformation($request->mac)->id;

        $qr_operator_list['list'] = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.of_id', $request->of_id)
            ->where('movements.movement_post_id', $current_post_id)
            ->get(["serial_number", "movements.created_at", "movements.result"]);

        // Get quantity of valid product (TODAY)
        $qr_operator_list['quantity_of_day'] = "0" . $qr_operator_list['list']->filter(function ($item) {
            return date('Y-m-d', strtotime($item['created_at'])) == Carbon::today()->toDateString();
        })->count();

        return $this->sendResponse(data: $qr_operator_list);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {
        // check movement
        $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr',  $request->qr)
            ->latest("movements.created_at")
            ->first(['serial_numbers.id', "serial_number", 'movement_post_id', 'result']);

        // Check & control product steps error
        if (!isset($this->checkProductSteps($request, $product)->current_post_id)) {
            return $this->checkProductSteps($request, $product);
        }

        // Prepare payload
        $payload = [
            'serial_number_id' => $product->id,
            'movement_post_id' => $this->checkProductSteps($request, $product)->current_post_id,
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
        if (!$product) {
            //Send response with error
            return $this->sendResponse('Product does not belong to the current OF', status: false);
        }

        // Check & control product steps error (if not exist current_post_id thats mean there is un error)
        $checkProductSteps = $this->checkProductSteps($request,  $product);
        if (!isset($checkProductSteps->current_post_id)) {
            return $checkProductSteps;
        }

        //Send response with success
        return $this->sendResponse(data: $product, status: true);
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
