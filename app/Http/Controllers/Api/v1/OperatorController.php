<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Of;
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
    public function index(Request $request, ProductService $productService)
    {
        $ofStatus = $productService->checkOfStatus($request->of_id, true);
        // dd($ofStatus);

        if ($ofStatus['error'] !== false) {
            $msg = __('response-messages.' . $ofStatus['message']);
            return $this->sendResponse($msg);
        }
        // Check status OF
        // $of = Of::findOrFail($request->of_id);
        // $ofStatus = $productService->checkOfStatus($of);
        // if ($ofStatus != NULL) {
        //     $msg = __('response-messages.' . $ofStatus['message']);
        //     return $this->sendResponse($msg);
        // }

        // Retrieve the movement list for the given Order Form and host ID
        $productsList = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.of_id', $request->of_id)
            ->where('movements.movement_post_id', $request->host_id)
            ->get(["serial_number", "movements.updated_at", "movements.result", "movements.updated_by"]);

        // Map the results based on conditions
        $results = $productsList->map(function ($item) {
            $today = now()->toDateString();
            $okAt = Carbon::parse($item['updated_at'])->toDateString();
            $okBy = $item['updated_by'];
            $userUsername = Auth::user()->username;

            return [
                "of_ok" =>  $item['result'] == "OK",
                "of_ok_today" => $okAt === $today && $item['result'] == "OK",
                "user_ok_today" => $okAt === $today && $okBy === $userUsername && $item['result'] == "OK",
                "user_nok_today" => $okAt === $today && $okBy === $userUsername && $item['result'] == "NOK",
            ];
        });

        // Count occurrences of each key
        $data = [
            "list" => $productsList, // Original list of ok products
            "of_ok" => $results->filter(fn ($item) => $item['of_ok'])->count(),
            "of_ok_today" => $results->filter(fn ($item) => $item['of_ok_today'])->count(),
            "user_ok_today" => $results->filter(fn ($item) => $item['user_ok_today'])->count(),
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
        $ofStatus = $productService->checkOfStatus($request->of_id);
        // dd($ofStatus);

        if ($ofStatus['error'] !== false) {
            $msg = __('response-messages.' . $ofStatus['message']);
            return $this->sendResponse($msg);
        }
        // Retrieve the latest movement record associated with the given serial number and order form ID
        $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr', $request->qr)
            ->where('serial_numbers.of_id', $request->of_id)
            ->latest('movements.created_at')
            ->first(['serial_numbers.id AS sn_id', 'movement_post_id', 'result',"serial_number_id"]);

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
        $msg = __("response-messages.success");
        return $this->sendResponse($msg);
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
        $ofStatus = $productService->checkOfStatus($request->of_id);
        // dd($ofStatus);

        if ($ofStatus['error'] !== false) {
            $msg = __('response-messages.' . $ofStatus['message']);
            return $this->sendResponse($msg);
        }

        // Get the last movement of a product with the specified QR and OF id
         $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr',  $request->qr)
            ->where('serial_numbers.of_id', $request->of_id)
            // ->where('movements.movement_post_id','!=',4)
            ->latest("movements.created_at")
            ->firstOrFail(['movement_post_id', 'result', 'serial_number', "of_id","serial_number_id"]);

        // Check if there are any errors with the product steps
        // If the current_post_id does not exist, there is an error
        return $productService->checkProductSteps($request, $product);
    }
}