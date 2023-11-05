<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Of;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckIpClient;

class RepairController extends Controller
{
    public function __construct()
    {
        // $this->middleware(CheckIpClient::class . ":4"); # 2 is operator post_type id
        // Add more middleware and specify the desired methods if needed
        // $this->middleware('permission:movement-list', ['only' => ['index']]);
        // $this->middleware(['permission:movement-create', 'permission:movement-list'], ['only' => ['store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            // ->where('serial_numbers.of_id', $of_id)
            // ->where('movements.result', "NOK")
            ->where('movements.movement_post_id', 4)
            ->latest('movements.updated_at')
            ->take(10)
            ->get(['serial_number', 'movements.result', 'movements.updated_at'/*, 'observation', 'movements.updated_by'*/]);

        // $data = compact(['info', 'list']);
        // Return the response
        return $this->sendResponse(data: $list);
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
            // ->where('movements.result', "NOK")
            ->latest('movements.updated_at')
            ->firstOrFail(['serial_numbers.id AS sn_id', 'movement_post_id', 'result', 'movements.updated_at']);
        if ($product->result == 'OK') {
            // Send success response
            $msg = __('Ce produit est OK');
            return $this->sendResponse($msg);
        }
        // Prepare payload for new movement record
        $payload = [
            'serial_number_id' => $product->sn_id,
            'movement_post_id' => 4, //$current_post_id,
            'result' => $request->result,
            // 'observation' => $request->observation,
        ];

        // Create new movement record
        $movement = Movement::create($payload);

        // Send success response
        $msg = __('response-messages.success');
        return $this->sendResponse($msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @var void $checkProductSteps
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Movement::join('posts', 'movements.movement_post_id', '=', 'posts.id')
            ->where('serial_numbers.qr', $id)
            // ->where('posts_type_id', '!=', 4)
            // ->where('movements.result', 'NOK')
            ->orderBy('movements.updated_at', 'DESC')
            ->join('serial_numbers', 'movements.serial_number_id', '=', 'serial_numbers.id')
            ->join('ofs', 'serial_numbers.of_id', '=', 'ofs.id')
            ->join('calibers', 'ofs.caliber_id', '=', 'calibers.id')
            ->join('products', 'calibers.product_id', '=', 'products.id')
            ->select('of_number', 'caliber_name', 'serial_number', 'product_name', 'post_name as nok_post')

            ->firstOrFail();

        if ($product->result == 'OK') {
            // Send success response
            $msg = __('Ce produit est OK');
            return $this->sendResponse($msg);
        }
        // $list = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
        //     // ->where('serial_numbers.of_id', $of_id)
        //     // ->where('movements.result', "NOK")
        //     ->where('movements.movement_post_id', 4)
        //     ->get(['serial_number', 'movements.updated_at', 'movements.result', 'observation', 'movements.updated_by']);

        // $data = compact(['info', 'list']);
        // // Return the response
        return $this->sendResponse(data: $product);
    }
}
