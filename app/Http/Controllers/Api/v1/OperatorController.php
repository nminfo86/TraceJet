<?php

namespace App\Http\Controllers\api\v1;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Movement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProductService;

class OperatorController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
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
        $qr_operator_list = [];

        // Get the list of movements for the given OF and host ID
        $qr_operator_list['list'] = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.of_id', $request->of_id)
            ->where('movements.movement_post_id', $request->host_id)
            ->get(["serial_number", "movements.created_at", "movements.result"]);

        // Filter the list to get the quantity of valid products for today
        $qr_operator_list['quantity_of_day'] = "0" . $qr_operator_list['list']
            ->filter(function ($item) {
                return date('Y-m-d', strtotime($item['created_at'])) == Carbon::today()->toDateString();
            })
            ->count();

        // Send the response with the result
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
        // Retrieve the latest movement record associated with the given serial number and order form ID
        $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr', $request->qr)
            ->where('serial_numbers.of_id', $request->of_id)
            ->latest('movements.created_at')
            ->first(['serial_numbers.id AS sn_id', 'movement_post_id', 'result']);

        // Check if there were any errors in the product steps
        $checkProductSteps = $this->productService->checkProductSteps($request, $product)->getData();

        // If there were errors, return the error response
        if (!isset($checkProductSteps->data)) {
            return $checkProductSteps;
        }

        // Prepare payload for new movement record
        $payload = [
            'serial_number_id' => $product->sn_id,
            'movement_post_id' => $checkProductSteps->data->current_post_id,
            'result' => $request->result,
        ];

        // Create new movement record
        $movement = Movement::create($payload);

        // Send success response
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
        // Get the last movement of a product with the specified QR and OF id
        $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr',  $request->qr)
            ->where('serial_numbers.of_id', $request->of_id)
            ->latest("movements.created_at")
            ->first(['movement_post_id', 'result', 'serial_number', "of_id"]);

        // Check if there are any errors with the product steps
        // If the current_post_id does not exist, there is an error
        return $this->productService->checkProductSteps($request, $product);
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
