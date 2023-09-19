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
        $this->middleware(CheckIpClient::class . ":1"); # 1 is label_generator post_type id

        // Add more middleware and specify the desired methods if needed
        $this->middleware('permission:serial_number-list', ['only' => ['index']]);
        $this->middleware(['permission:serial_number-create', 'permission:serial_number-list'], ['only' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // Fetch the list of valid products
        $productsList = SerialNumber::whereOfId($request->of_id)->whereValid(1)
            ->get(["serial_number", "valid as result", "updated_at", "updated_by"]);

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
            "of_ok" => $productsList->count(),
            "of_ok_today" => $results->filter(fn ($item) => $item['of_ok_today'])->count(),
            "user_ok_today" => $results->filter(fn ($item) => $item['user_ok_today'])->count(),
            "user_nok_today" => $results->filter(fn ($item) => $item['user_nok_today'])->count(),

        ];
        $msg = "";
        if ($request->printer == NULL) {
            $msg = "vérifier la connexion à l'imprimante.";
        }
        // Return the response
        return $this->sendResponse($msg, data: $data);
    }


    public function checkOfStatus(Object $of)
    {
        $error = false;
        $message = "";
        if ($of->status->value == "closed") {
            $message = "of_closed";
            $error = true;
        }

        // Check with OF quantity
        if ($of->new_quantity === $this->countValidProducts($of->id)) {
            $message = "of_valid";
            $error = true;
        }
        return ["error" => $error, "message" => $message];
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


        $ofStatus = $this->checkOfStatus($of);
        if ($ofStatus['error'] == true) {
            $msg = __('response-messages.' . $ofStatus['message']);
            return $this->sendResponse($msg);
        }

        // if ($of->status->value == "closed") {
        //     // Return a success response indicating that the OF is already closed
        //     $msg = __('response-messages.of_closed');
        //     return $this->sendResponse($msg, true);
        // }

        // // Check with OF quantity
        // if ($of->new_quantity === $this->countValidProducts($of->id)) {
        //     $msg = __('response-messages.of_valid');
        //     //Send response with Error
        //     return $this->sendResponse($msg);
        // }
        //TODO::add alert about all sn is valid and of not closed

        // Retrieve the SerialNumber with the provided QR code and that has not been validated yet
        $product = SerialNumber::where('qr', $request->qr)
            ->where('valid', 0)
            ->first();


        // If the SerialNumber is not found
        if (!$product) {
            // Return an error response indicating that the product is not found
            $msg = __("exception-errors.resource_not_found");
            return $this->sendResponse($msg, status: false);
        }

        // Mark the product as validated and create new movement
        $validProduct = $product->update(['valid' => 1]);

        if ($validProduct && Movement::where('serial_number_id', $product->id)->count() == 0) {
            Movement::create([
                "serial_number_id" => $product->id,
                "movement_post_id" => $request->host_id,
                "result" => "OK"
            ]);
        }

        // Generate a new SerialNumber
        return $this->generateNewSN($of, $request->printer);
    }


    /**
     * generateNewSN
     *
     * @param  mixed $of_id
     * @return \Illuminate\Http\Response
     */
    public function generateNewSN(Object $of, $printer)
    {
        $ofStatus = $this->checkOfStatus($of);
        if ($ofStatus['error'] == true) {
            $msg = __('response-messages.' . $ofStatus['message']);
            return $this->sendResponse($msg, true);
        }

        /* -------------------------------------------------------------------------- */
        /*                                    TEST                                    */
        /* -------------------------------------------------------------------------- */
        // Generate the serial number for the new product
        $last_sn = SerialNumber::whereOfId($of->id)->orderBy('id', 'desc')->first();
        $serial_number = str_pad($last_sn->serial_number + 1, 3, '0', STR_PAD_LEFT);

        // Create the new SerialNumber record
        $new_sn = SerialNumber::create([
            'of_id' => $last_sn->of_id,
            'serial_number' => $serial_number,
        ]);

        /* -------------------------------------------------------------------------- */
        /*                                  Printing                                  */
        /* -------------------------------------------------------------------------- */
        // return $this->toPrinter($printer,   $new_sn->qr);

        $qrCode = $new_sn->qr;
        return $this->sendToPrinter($printer, $qrCode);
        // $printLabel = new PrintLabelService($printer);
        // $printLabel->printProductLabel($qrCode);


        // 932113600012023#001#CX1000-3#001#2023-02-13 22:17:22
        // $qr = explode("#", $qrCode);
        // $sn = $qr[3];
        // $of_num = $qr[1];
        // $product_name = $qr[2];
        // $printLabel->printProductLabel($qrCode, $of_num, $product_name, $sn);
        // Return a success message with the QR code for the new product
        // $this->sendToPrinter($printer, $new_sn->qr);
        // $msg = __('response-messages.printing');
        // return $this->sendResponse($msg, $new_sn->only('qr'));
    }


    // This method prints the QR code for a product based on the given request
    public function PrintQrCode(Request $request)
    {
        // dd($request->all());
        // Check if the Order Form (OF) with the given ID is closed
        $of = OF::findOrFail($request->of_id);
        $ofStatus = $this->checkOfStatus($of);
        if ($ofStatus['error'] == true) {
            $msg = __('response-messages.' . $ofStatus['message']);
            return $this->sendResponse($msg, true);
        }
        // Check if any product exists for the given OF ID
        $productExists = SerialNumber::whereOfId($request->of_id)->exists();

        // If no product exists, create the first record with serial number '001'
        if (!$productExists) {
            $request['serial_number'] = str_pad(1, 3, 0, STR_PAD_LEFT);
            $newProduct = SerialNumber::create($request->all());

            // return $this->toPrinter("192.168.1.100", "TSPL", "40_20",  $newProduct->qr);
            return $this->sendToPrinter($request->printer,  $newProduct->qr);
        }
        // dd($request->printer);
        // If a product already exists, generate a new serial number and create the record
        // $of_quantity = Of::findOrFail($request->of_id, ["new_quantity"])->new_quantity;
        return $this->generateNewSN($of, $request->printer);
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



    public function sendToPrinter($printer = null, String $productQr)
    {
        // dd($printer);
        // $printLabel = new PrintLabelService($printer);
        // $printLabel->printProductLabel($productQr);

        // dd($printLabel->printProductLabel($productQr));
        // dd($productQr);
        // $qrCode = $->qr;        // 932113600012023#001#CX1000-3#001#2023-02-13 22:17:22

        // Prepare label information
        // dd($productQr);
        if (!$printer) {
            // dd();
            $msg = __('response-messages.success');
            return $this->sendResponse($msg, $productQr);
        }
        // // dd($printer);
        $printLabel = new PrintLabelService($printer);

        if ($printLabel->printProductLabel($productQr)) {
            # code...
            $msg = __('response-messages.printing');
        } else {
            $msg = __('response-messages.success');
        }
        return $this->sendResponse($msg, $productQr);
    }
}
