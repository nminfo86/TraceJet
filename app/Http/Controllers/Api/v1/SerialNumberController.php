<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Of;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Services\PrintLabelService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Middleware\CheckIpClient;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreRequests\StoreSerialNumberRequest;

class SerialNumberController extends Controller
{
    public function __construct()
    {
        // $this->middleware(CheckIpClient::class . ":1"); # 1 is label_generator post_type id
        // Add more middleware and specify the desired methods if needed
        $this->middleware('permission:serial_number-list', ['only' => ['index']]);
        $this->middleware(['permission:serial_number-create', 'permission:serial_number-list'], ['only' => ['store']]);
        // $this->middleware('permission:serial_number-edit', ['only' => ['show', 'update']]);
        // $this->middleware(['permission:serial_number-delete', 'permission:serial_number-list'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // Continue with the rest of your code
        $valid_products = SerialNumber::whereOfId($request->of_id)->whereValid(1)
            ->get(["serial_number", "updated_at"]);

        // Get the quantity of valid serial numbers for today
        $quantity_valid_for_today = $valid_products->filter(function ($item) {
            return date('Y-m-d', strtotime($item['updated_at'])) == Carbon::today()->toDateString();
        })->count();

        // Prepare the response data
        $data = [
            'list' => $valid_products,
            'quantity_of_day' => "0" . $quantity_valid_for_today
        ];

        // Return the response
        return $this->sendResponse(data: $data);
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
        $current_post = $this->postsListFromCache(1);

        if (isset($current_post['status'])) {
            // Handle the case where the post does not exist in the user's section
            return $this->sendResponse($current_post["message"], status: false);
        }


        // Check if the Order Form (OF) with the given ID is closed
        $of = OF::findOrFail($request->of_id);

        if ($of->status->value == "closed") {
            // Return a success response indicating that the OF is already closed
            $msg = $this->getResponseMessage('of_closed');
            return $this->sendResponse($msg, true);
        }
        //TODO::add alert about all sn is valid and of not closed

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
        return $this->generateNewSN($request->of_id, $of->new_quantity);
    }


    /**
     * generateNewSN
     *
     * @param  mixed $of_id
     * @return \Illuminate\Http\Response
     */
    public function generateNewSN($of_id, $of_quantity)
    {
        // dd($of_quantity . "/" . $this->countValidProducts($of_id));
        // Check with OF quantity
        if ($of_quantity === $this->countValidProducts($of_id)) {

            //Send response with Error
            return $this->sendResponse("OF Valid");
        }
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


        // $printLabel = new PrintLabelService("192.168.1.100", "TSPL", "40_20");
        // $qrCode = $new_sn->qr;
        // // 932113600012023#001#CX1000-3#001#2023-02-13 22:17:22
        // $qr = explode("#", $qrCode);
        // $sn = $qr[3];
        // $of_num = $qr[1];
        // $product_name = $qr[2];
        // $printLabel->printProductLabel($qrCode, $of_num, $product_name, $sn);
        // // Return a success message with the QR code for the new product
        // $this->sendToPrinter("192.168.1.100", "TSPL", "40_20", $new_sn->qr);
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

            //Print QR
            // $this->sendToPrinter("192.168.1.100", "TSPL", "40_20", $newProduct->qr);
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
    public function countValidProducts($of_id)
    {
        return SerialNumber::whereOfId($of_id)->whereValid(1)->count();
    }




    public function productLife($id)
    {
        return Movement::whereSerialNumberId($id)
            ->join("posts", "movement_post_id", "posts.id")
            ->get(["post_name", "color", "result", "movements.created_at", "movements.created_by"]);
    }


    // public function sendToPrinter($ip_address, $type, $label, $qr_code)
    // {
    //     // $printLabel = new PrintLabelService("192.168.98.121", "TSPL", "40_20");
    //     // $qrCode = $new_sn->qr;
    //     $printLabel = new PrintLabelService($ip_address, $type, $label);
    //     // $qrCode = $new_sn->qr;

    //     // 932113600012023#001#CX1000-3#001#2023-02-13 22:17:22
    //     $qr = explode("#", $qr_code);
    //     $sn = $qr[3];
    //     $of_num = $qr[1];
    //     $product_name = $qr[2];
    //     $printLabel->printProductLabel($qr_code, $of_num, $product_name, $sn);
    // }

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


    // //valid product
    // public function store(StoreSerialNumberRequest $request)
    // {

    //     // get invalid product with QR code
    //     $product = SerialNumber::with("of:id,new_quantity")->whereQr($request->qr)->whereValid(0)->first();

    //     // Check qr in db
    //     if ($product) {

    //         $of_quantity = $product->of->new_quantity;

    //         // Check with OF quantity
    //         if ($of_quantity <= $this->countValidProducts($request->of_id)) {

    //             // Send response with error
    //             return $this->sendResponse("OF Valid", status: true);
    //         }

    //         // Valid product
    //         $product->update(['valid' => 1]);

    //         // Create new sn (next serial number)
    //         return $this->generateNewSN($request->of_id, $of_quantity);
    //     }

    //     // Send response with error
    //     return $this->sendResponse("This product valid or does not belong to this OF", status: false);
    // }


    // public function generateNewSN($of_id, $of_quantity)
    // {

    //     // Check with OF quantity
    //     if ($of_quantity <= $this->countValidProducts($of_id)) {

    //         //Send response with Error
    //         return $this->sendResponse("OF Valid");
    //     }

    //     // Get last sn by of_id
    //     $product = SerialNumber::whereOfId($of_id)->orderBy("id", "desc")->first();

    //     // Increment SN
    //     $product->serial_number++;

    //     // Create new sn (next serial number)
    //     $new_sn = SerialNumber::create([
    //         "of_id" => $product->of_id,
    //         "serial_number" =>  str_pad($product->serial_number++, 3, 0, STR_PAD_LEFT),
    //     ]);

    //     //Send response with QR success
    //     return $this->sendResponse($this->create_success_msg, $new_sn->only('qr'));
    // $printLabel = new PrintLabelService("192.168.98.121", "TSPL", "40_20");
    // $qrCode = $new_sn->qr;

    // // 932113600012023#001#CX1000-3#001#2023-02-13 22:17:22
    // $qr = explode("#", $qrCode);
    // $sn = $qr[3];
    // $of_num = $qr[1];
    // $product_name = $qr[2];
    // $printLabel->printProductLabel($qrCode, $of_num, $product_name, $sn);
    // }
}
