<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Of;
use Carbon\Carbon;
use App\Models\Box;
use App\Models\Caliber;
use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Services\ProductService;
use App\Services\MovementService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckIpClient;
use App\Models\Setting;
use Illuminate\Support\Facades\Response;

class PackagingController extends Controller
{
    // private $productService;

    // public function __construct(ProductService $productService)
    // {
    //     $this->productService = $productService;
    // }
    public function __construct()
    {
        $this->middleware(CheckIpClient::class . ":3"); # 3 is operator post_type id
        // Add more middleware and specify the desired methods if needed
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, ProductService $productService)
    {
        $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr', $request->qr)
            ->latest('movements.created_at')
            ->first(['serial_numbers.id AS serial_number_id', 'movement_post_id', 'result', 'of_id']);

        /* -------------------------------------------------------------------------- */
        /*                                  CLose OF                                  */
        /* -------------------------------------------------------------------------- */
        $of = Of::findOrFail($product->of_id);

        if ($of->status->value == 'closed') {
            return  $this->sendResponse('OF Closed');
        }

        // Check if there were any errors in the product steps
        $checkProductSteps = $productService->checkProductSteps($request, $product)->getData();

        // If there were errors, return the error response
        if (!isset($checkProductSteps->data)) {
            return $checkProductSteps;
        }

        $product = $checkProductSteps->data;


        // $this->CheckOfStatus($product->of_id);

        // Create new movement
        return  $this->newPackaging($request->result, $of, $product);
    }


    /**
     * newPackaging
     *
     * @param  mixed $result
     * @param  mixed $product
     * @return \Illuminate\Http\Response
     */
    public function newPackaging(mixed $result, $of, mixed $product)
    {
        try {
            DB::beginTransaction();

            // Create new movement
            $this->createNewMovement($result, $product);

            // start of packing operation
            $response = $this->boxed($of, $product);
            DB::commit();

            //Send response with success
            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function createNewMovement($result, $product)
    {
        // Prepare payload for new movement record
        $payload = [
            'serial_number_id' => $product->serial_number_id,
            'movement_post_id' => $product->current_post_id,
            'result' => $result,
        ];

        // Create new movement
        return  Movement::create($payload);
    }



    /**
     * Boxes a product based on the given last movement.
     * @param \App\Models\Movement $product
     * @return array
     */
    public function boxed($of, $product)
    {
        $box_ticket = [];
        // Get the OF id and serial number id and box_quantity
        $of_id = $of->id;
        $of_quantity = $of->new_quantity;
        $sn_id = $product->serial_number_id;
        $box_quantity = $of->caliber->box_quantity;
        $host_id = $product->current_post_id;
        // dd($product);

        // Perform the packaging operation for a given OF  and Serial Number and box_quantity
        $box_ticket = $this->boxedOperation($of, $box_quantity, $sn_id);

        // Get the count of serial numbers that have a box assigned
        $snCount = $of->serialNumbers()->whereNotNull('box_id')->count();

        if ($of_quantity === $snCount) {
            if ($of->status->value !== 'closed') {
                // If all serial numbers have a box assigned, close the OF
                $of->update(['status' => 'closed']);

                // Update the status of boxes associated with the OF
                Box::whereOfId($of_id)->update(['status' => 'filled']);
            }
            // Get and prepare product information
            // $info = $this->getOfInformation($of_id);
            $msg = $this->getResponseMessage("of_closed");
        }

        // Get and prepare product information and  list of boxed product
        $response = $this->prepareResponse($of_id, $host_id, $box_ticket);

        // Return the response
        $msg = $this->getResponseMessage("success");
        return $this->sendResponse($msg, $response);
    }


    /** Perform the packaging operation for a given OF and Serial Number
     * @param int $of_id
     * @param int $box_quantity
     * @param int $sn_id
     * @return void
     */
    private function boxedOperation($of, int $box_quantity, int $sn_id)
    {
        // dd($of);
        $of_id = $of->id;
        $product_id = $of->caliber->product_id;
        // dd($product_id);
        // Check if there is an open box for the given OF, create one if there is none
        $last_open_box = Box::whereOfId($of_id)->whereStatus('open')->latest()->first();
        if (!$last_open_box) {
            $last_open_box = Box::create(['of_id' => $of_id]);
        }

        // Count the number of products in the last open box before updating the serial number
        $boxed_products = $this->countProductsInOpenedBox($of, $last_open_box->id);
        // dd($box_quantity);

        // Update the box ID for the current serial number if the current box is not filled yet
        if ($boxed_products < $box_quantity) {
            SerialNumber::find($sn_id, ["id", "box_id"])->update(['box_id' => $last_open_box->id]);
            // Count products boxed in the last open box after updating serial number
            $boxed_products = $this->countProductsInOpenedBox($of, $last_open_box->id);
        }

        // Update the status of the last open box to 'filled' if it's full
        if ($boxed_products == $box_quantity) {
            Box::find($last_open_box->id)->update(['status' => "filled"]);

            $product_name = Caliber::whereProductId($product_id)->join('products', 'calibers.product_id', 'products.id')->select(DB::raw("CONCAT(product_name, ' ', caliber_name) as product"))->first()->product;

            $info = Setting::first();
            $info->box_qr = $last_open_box->box_qr;
            $info->boxed_date = $last_open_box->created_at;
            $info->box_quantity = $box_quantity;
            $info->product = $product_name;


            $box_ticket['serial_numbers'] = SerialNumber::whereBoxId($last_open_box->id)->pluck("serial_number");
            $box_ticket['info'] = $info;
            // $box_ticket['info'] = ["box_qr" => $last_open_box->box_qr, "boxed_date" => $last_open_box->created_at, "box_quantity" => $box_quantity, "product" => $product_name];
            return $box_ticket;
        }
    }


    /**
     * countProductsInOpenedBox
     *
     * @param $of
     * @param  int $box_id
     * @return int
     */
    private function countProductsInOpenedBox($of, int $box_id)
    {
        return $of->serialNumbers()->whereBoxId($box_id)->count();
    }


    /**
     * Get the product information for a given OF ID.
     *
     * @param int $of_id The ID of the OF to retrieve product information for.
     * @param int $host_id The ID of the current post .
     *
     * @return Object
     */
    public function prepareResponse(int $of_id, int $host_id, $box_ticket)
    {
        $list = $this->getMovementDetail($of_id, $host_id);

        $info = SerialNumber::join('ofs', 'serial_numbers.of_id', '=', 'ofs.id')
            ->join('calibers', 'ofs.caliber_id', '=', 'calibers.id')
            ->join('products', 'calibers.product_id', '=', 'products.id')
            ->join('boxes', 'serial_numbers.box_id', '=', 'boxes.id')
            ->select(
                'of_number',
                'ofs.status',
                'ofs.created_at',
                'boxes.status as box_status',
                'calibers.box_quantity',
                'caliber_name',
                'serial_number',
                'product_name',
                'ofs.new_quantity as quantity',
                DB::raw("SUBSTRING_INDEX(boxes.box_qr, '-', -1) as box_number"),
                DB::raw("(select FLOOR(quantity/box_quantity)) as of_boxes")
                // DB::raw("COUNT(DISTINCT  box_id) as boxes_packaged"),
                // DB::raw("COUNT(serial_numbers.id) as products_packaged"),
            )->where('serial_numbers.of_id', '=', $of_id)
            ->orderBy("serial_numbers.updated_at", "DESC")
            ->first();

        $info->quantity_of_day = "0" . $list
            ->filter(function ($item) {
                return date('Y-m-d', strtotime($item['created_at'])) == Carbon::today()->toDateString();
            })
            ->count();

        // If the product information was found, calculate the number of OF boxes
        // if ($product_info) {
        //     $product_info->of_boxes = floor($product_info->of_boxes);
        // }

        if ($box_ticket) {
            // return   $this->sendResponse(data: $box_ticket);
            return compact("info", "list", "box_ticket");
        }
        return compact("info", "list");
    }



    /**
     * getMovementDetail
     *
     * @param  Int $of_id
     * @param  Int $host_id
     * @return Object
     */
    public function getMovementDetail(Int $of_id, Int $host_id)
    {
        return Movement::join("serial_numbers", "movements.serial_number_id", "serial_numbers.id")
            ->whereMovementPostId($host_id)
            ->whereOfId($of_id)->get(["serial_numbers.serial_number", "result", "movements.created_at"]);
    }
}
