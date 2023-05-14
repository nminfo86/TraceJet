<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Of;
use Carbon\Carbon;
use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreSerialNumberRequest;

class SerialNumberController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        // Get serial numbers valid list
        $product['list'] = SerialNumber::whereOfId($request->of_id)->whereValid(1)->get(["serial_number", "updated_at"]);

        // Get quantity of valid product (TODAY)
        $product['quantity_of_day'] = "0" . $product['list']->filter(function ($item) {
            return date('Y-m-d', strtotime($item['updated_at'])) == Carbon::today()->toDateString();
        })->count();
        return $this->sendResponse(data: $product);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //valid product
    public function store(StoreSerialNumberRequest $request)
    {
        // Check if the Order Form (OF) with the given ID is closed
        $of = OF::findOrFail($request->of_id);

        if ($of->status->value == "closed") {
            // Return a success response indicating that the OF is already closed
            $msg = $this->getResponseMessage('of_closed');
            return $this->sendResponse($msg, true);
        }

        // Retrieve the SerialNumber with the provided QR code and that has not been validated yet
        $product = SerialNumber::where('qr', $request->qr)
            ->where('valid', 0)
            ->first();

        // If the SerialNumber is not found
        if (!$product) {
            // Return an error response indicating that the product is not found
            $msg = $this->getResponseMessage('not_found', ['attribute' => 'product']);
            return $this->sendResponse($msg, status: false);
        }

        // Mark the product as validated
        $product->update(['valid' => 1]);

        // Generate a new SerialNumber
        return $this->generateNewSN($request->of_id);
    }


    /**
     * generateNewSN
     *
     * @param  mixed $of_id
     * @return \Illuminate\Http\Response
     */
    public function generateNewSN($of_id)
    {
        /* -------------------------------------------------------------------------- */
        /*                                    TEST                                    */
        /* -------------------------------------------------------------------------- */
        // Generate the serial number for the new product
        $last_sn = SerialNumber::whereOfId($of_id)->orderBy('id', 'desc')->first();
        $serial_number = str_pad($last_sn->serial_number + 1, 3, '0', STR_PAD_LEFT);

        // Create the new SerialNumber record
        $new_sn = SerialNumber::create([
            'of_id' => $last_sn->of_id,
            'serial_number' => $serial_number,
        ]);

        // Return a success message with the QR code for the new product
        $msg = $this->getResponseMessage('print_qr-success');
        return $this->sendResponse($msg, $new_sn->only('qr'));
    }


    // This method prints the QR code for a product based on the given request
    public function PrintQrCode(Request $request)
    {
        // Check if any product exists for the given OF ID
        $productExists = SerialNumber::whereOfId($request->of_id)->exists();

        // If no product exists, create the first record with serial number '001'
        if (!$productExists) {
            $request['serial_number'] = str_pad(1, 3, 0, STR_PAD_LEFT);
            $newProduct = SerialNumber::create($request->all());

            // Send success response with the QR code of the newly created product
            $message = $this->getResponseMessage("print_qr-success");
            return $this->sendResponse($message, $newProduct->only('qr'));
        }

        // If a product already exists, generate a new serial number and create the record
        $of_quantity = Of::findOrFail($request->of_id, ["new_quantity"])->new_quantity;
        return $this->generateNewSN($request->of_id, $of_quantity);
    }

    /**
     * countValidProducts
     *
     * @param  mixed $of_id
     * @return Int
     */
    // public function countValidProducts($of_id)
    // {
    //     return SerialNumber::whereOfId($of_id)->whereValid(1)->count();
    // }




    public function productLife($id)
    {
        return Movement::whereSerialNumberId($id)
            ->join("posts", "movement_post_id", "posts.id")
            ->get(["post_name", "color", "result", "movements.created_at", "movements.created_by"]);
    }

    // public function FunctionName(Type $var = null)
    // {
    //     // $printLabel = new PrintLabelService("192.168.98.121", "TSPL", "40_20");
    //     // $qrCode = $new_sn->qr;

    //     // // 932113600012023#001#CX1000-3#001#2023-02-13 22:17:22
    //     // $qr = explode("#", $qrCode);
    //     // $sn = $qr[3];
    //     // $of_num = $qr[1];
    //     // $product_name = $qr[2];
    //     // $printLabel->printProductLabel($qrCode, $of_num, $product_name, $sn);
    // }
}
