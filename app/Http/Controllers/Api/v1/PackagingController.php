<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Of;
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
use Illuminate\Support\Facades\Response;

class PackagingController extends Controller
{
    private $productService;

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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $product = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr', $request->qr)
            // ->where('serial_numbers.of_id', $request->of_id)
            ->latest('movements.created_at')
            ->first(['serial_numbers.id AS serial_number_id', 'movement_post_id', 'result', 'of_id']);

        // Check if there were any errors in the product steps
        $checkProductSteps = $this->productService->checkProductSteps($request, $product)->getData();

        // If there were errors, return the error response
        if (!isset($checkProductSteps->data)) {
            return $checkProductSteps;
        }

        $product = $checkProductSteps->data;


        $this->CheckOfStatus($product->of_id);

        // Create new movement
        return  $this->createMovement($request->result, $product);
    }


    /**
     * createMovement
     *
     * @param  mixed $result
     * @param  mixed $product
     * @return \Illuminate\Http\Response
     */
    public function createMovement(mixed $result, mixed $product)
    {
        // Prepare payload for new movement record
        $payload = [
            'serial_number_id' => $product->serial_number_id,
            'movement_post_id' => $product->current_post_id,
            'result' => $result,
        ];

        try {
            DB::beginTransaction();

            // Create new movement
            Movement::create($payload);

            $response = $this->packaging($product);
            DB::commit();

            // return   $this->closeOf($of_id);
            //Send response with success
            return $this->sendResponse(data: $response);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }



    /**
     * Boxes a product based on the given last movement.
     * @param \App\Models\Movement $last_movement
     * @return array
     */
    public function packaging($last_movement)
    {
        // Get the OF id and serial number id
        $of_id = $last_movement->of_id;
        $sn_id = $last_movement->serial_number_id;

        // Get box quantity from the caliber
        $caliber_id = OF::FindOrFail($of_id, ['caliber_id'])->caliber_id;
        $box_quantity = Caliber::FindOrFail($caliber_id, ['box_quantity'])->box_quantity;

        // Perform the packaging operation for a given OF  and Serial Number and box_quantity
        $this->packagingOperation($of_id, $box_quantity, $sn_id);

        // Get product information and boxed products for the response
        $response["info"] = $this->getProductInformation($of_id);
        $response["list"] = SerialNumber::whereOfId($of_id)->whereNotNull("box_id")->get(["serial_number", "created_at"]);

        // Return the response
        return $response;
    }


    /** Perform the packaging operation for a given OF and Serial Number
     * @param int $of_id
     * @param int $box_quantity
     * @param int $sn_id
     * @return void
     */
    private function packagingOperation(int $of_id, int $box_quantity, int $sn_id)
    {
        // Check if there is an open box for the given OF, create one if there is none
        $last_open_box = Box::whereOfId($of_id)->whereStatus('open')->latest()->first();
        if (!$last_open_box) {
            $last_open_box = Box::create(['of_id' => $of_id]);
        }

        // Count the number of products in the last open box before updating the serial number
        $boxed_products = $this->countProductsInOpenedBox($last_open_box->id, $of_id);

        // Update the box ID for the current serial number if the current box is not filled yet
        if ($boxed_products < $box_quantity) {
            SerialNumber::find($sn_id, ["id", "box_id"])->update(['box_id' => $last_open_box->id]);
            // Count products boxed in the last open box after updating serial number
            $boxed_products = $this->countProductsInOpenedBox($last_open_box->id, $of_id);
        }

        // Update the status of the last open box to 'filled' if it's full
        if ($boxed_products == $box_quantity) {
            Box::find($last_open_box->id)->update(['status' => "filled"]);
        }
    }

    private function CheckOfStatus($of_id)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Close of                                  */
        /* -------------------------------------------------------------------------- */
        $of = Of::findOrFail($of_id)->firstOrFail();
        $sn = SerialNumber::whereOfId($of_id)->whereNotNull("box_id")->count();
        if ($of->quantity === $sn) {
            $of->update(["status" => "closed"]);

            $response["list"] = SerialNumber::whereOfId($of_id)->whereNotNull("box_id")->get(["serial_number", "created_at"]);
            // return $of;
            //Send response with msg
            return $this->sendResponse("OF Closed", $response, false);
        } else return;
        /* ------------------------------ End close of ------------------------------ */
    }




    /**
     * countProductsInOpenedBox
     *
     * @param  int $box_id
     * @param  int $of_id
     * @return int
     */
    private function countProductsInOpenedBox($box_id, $of_id)
    {
        return SerialNumber::whereOfId($of_id)->whereBoxId($box_id)->count();
    }



    /**
     * Get the product information for a given OF ID.
     *
     * @param int $of_id The ID of the OF to retrieve product information for.
     *
     * @return void
     */
    public function getProductInformation($of_id)
    {
        $product_info = SerialNumber::join('ofs', 'serial_numbers.of_id', '=', 'ofs.id')
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
                'ofs.quantity as quantity',
                DB::raw("SUBSTRING_INDEX(boxes.box_qr, '-', -1) as box_number"),
                DB::raw("(select FLOOR(quantity/box_quantity)) as of_boxes")
                // DB::raw("COUNT(DISTINCT  box_id) as boxes_packaged"),
                // DB::raw("COUNT(serial_numbers.id) as products_packaged"),
            )->where('serial_numbers.of_id', '=', $of_id)
            ->orderBy("serial_numbers.updated_at", "DESC")
            ->first();

        // If the product information was found, calculate the number of OF boxes
        // if ($product_info) {
        //     $product_info->of_boxes = floor($product_info->of_boxes);
        // }
        return $product_info;
    }
}
