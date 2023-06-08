<?php

namespace App\Http\Controllers\api\v1;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Movement;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckIpClient;

class OperatorController extends Controller
{
    protected $productService;

    // public function __construct(ProductService $productService)
    // {
    //     $this->productService = $productService;
    // }
    public function __construct()
    {
        $this->middleware(CheckIpClient::class . ":2"); # 2 is operator post_type id
        // Add more middleware and specify the desired methods if needed
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Retrieve the movement list for the given Order Form and host ID
        $products = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.of_id', $request->of_id)
            ->where('movements.movement_post_id', $request->host_id)
            ->get(["serial_number", "movements.created_at", "movements.result"]);

        // Filter the movements list to get the count of movements made today
        $quantity_of_day = $products->filter(function ($item) {
            return date('Y-m-d', strtotime($item['created_at'])) == Carbon::today()->toDateString();
        })
            ->count();

        // Construct the response array
        $response = [
            'list' => $products,
            'quantity_of_day' => "0" . $quantity_of_day
        ];

        // Return the response
        return $this->sendResponse(data: $response);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */

    /* @var checkProductSteps void */
    public function store(Request $request, ProductService $productService)
    {
        // Retrieve the latest movement record associated with the given serial number and order form ID
        $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr', $request->qr)
            ->where('serial_numbers.of_id', $request->of_id)
            ->latest('movements.created_at')
            ->first(['serial_numbers.id AS sn_id', 'movement_post_id', 'result']);

        // Check if there were any errors in the product steps
        $checkProductSteps = $productService->checkProductSteps($request, $product)->getData();

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
    public function show(Request $request, ProductService $productService)
    {
        // Get the last movement of a product with the specified QR and OF id
        $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr',  $request->qr)
            ->where('serial_numbers.of_id', $request->of_id)
            ->latest("movements.created_at")
            ->first(['movement_post_id', 'result', 'serial_number', "of_id"]);

        // Check if there are any errors with the product steps
        // If the current_post_id does not exist, there is an error
        return $productService->checkProductSteps($request, $product);
    }
}
