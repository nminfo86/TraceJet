<?php

namespace App\Http\Controllers\api\v1;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Movement;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckIpClient;

class OperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(CheckIpClient::class . ":2"); # 2 is operator post_type id
        // Add more middleware and specify the desired methods if needed
        $this->middleware('permission:movement-list', ['only' => ['index']]);
        $this->middleware(['permission:movement-create', 'permission:movement-list'], ['only' => ['store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // Retrieve the movement list for the given Order Form and host ID
        $productsList = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.of_id', $request->of_id)
            ->where('movements.movement_post_id', $request->host_id)
            ->get(["serial_number", "movements.updated_at", "movements.result", "movements.updated_by"]);

        // Map the results based on conditions
        $results = $productsList->map(function ($item) {
            $today = now()->toDateString();
            $validAt = Carbon::parse($item['updated_at'])->toDateString();
            $validBy = $item['updated_by'];
            $userUsername = Auth::user()->username;

            return [
                "user_valid_today" => $validAt === $today && $validBy === $userUsername,
                "user_valid_of" => $validBy === $userUsername,
                "quantity_valid_today" => $validAt === $today,

                //result NOK
                "user_nok_today" => $validAt === $today && $validBy === $userUsername && $item['result'] == "NOK",
            ];
        });

        // Count occurrences of each key
        $data = [
            "list" => $productsList, // Original list of valid products
            "count_list" => $productsList->count(),
            "quantity_valid_today" => $results->filter(fn ($item) => $item['quantity_valid_today'])->count(),
            "user_valid_today" => $results->filter(fn ($item) => $item['user_valid_today'])->count(),
            "user_valid_of" => $results->filter(fn ($item) => $item['user_valid_of'])->count(),
            "user_nok_today" => $results->filter(fn ($item) => $item['user_nok_today'])->count(),
        ];

        // Return the response
        return $this->sendResponse(data: $data);
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
        return $this->sendResponse($this->create_success_msg);
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
