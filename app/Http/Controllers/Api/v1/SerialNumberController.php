<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Of;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;
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
                "of_ok" =>  $item['result'] == 1,
                "of_ok_today" => $okAt === $today && $item['result'] == 1,
                "user_ok_today" => $okAt === $today && $okBy === $userUsername && $item['result'] === 1,
                "user_nok_today" => $okAt === $today && $okBy === $userUsername && $item['result'] !== 1,
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //valid product
    public function store(StoreSerialNumberRequest $request, ProductService $productService)
    {
        $ofStatus = $productService->checkOfStatus($request->of_id);
        if ($ofStatus['error'] === true) {
            // dd($ofStatus['error']);
            $msg = __('response-messages.' . $ofStatus['message']);
            return $this->sendResponse($msg);
        }

        // $of = $ofStatus['of'];
        // Retrieve the SerialNumber with the provided QR code and that has not been validated yet
        $product = SerialNumber::where('qr', $request->qr)->where('valid', 0)->where('of_id', $ofStatus['of']->id)
            ->firstOrFail();

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
        return $this->createNewProduct($request);
    }

    // This method prints the QR code for a product based on the given request
    public function PrintQrCode(Request $request, ProductService $productService)
    {
        // Check OF status
        $ofStatus = $productService->checkOfStatus($request->of_id);
        if ($ofStatus['error'] === true) {
            $msg = __('response-messages.' . $ofStatus['message']);
            return $this->sendResponse($msg);
        }

        // Check if any product exists for the given OF ID
        $productExists = SerialNumber::whereOfId($ofStatus['of']->id)->exists();

        // If no product exists, create the first record with serial number '001'
        if (!$productExists) {
            $request['serial_number'] = str_pad(1, 3, 0, STR_PAD_LEFT);
            $newProduct = SerialNumber::create($request->all());

            //generate qrCode
            $qrCode = $this->generateQrCode($newProduct);

            // Printing
            return $this->sendToPrinter($request->printer,  $qrCode);
        }
        return $this->createNewProduct($request);
    }

    /**
     * createNewProduct
     *
     * @param  mixed $of_id
     * @return \Illuminate\Http\Response
     */
    public function createNewProduct($request)
    {
        // Generate the serial number for the new product
        $last_sn = SerialNumber::whereOfId($request->of_id)->orderBy('id', 'desc')->first();
        $serial_number = str_pad($last_sn->serial_number + 1, 3, '0', STR_PAD_LEFT);

        // Create the new SerialNumber record
        $newProduct = SerialNumber::create([
            'of_id' => $last_sn->of_id,
            'serial_number' => $serial_number,
        ]);
        // Generate qrCode
        $qrCode = $this->generateQrCode($newProduct);

        // Printing
        return $this->sendToPrinter($request->printer, $qrCode);
    }




    public function sendToPrinter($printer = null, String $productQr)
    {
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


    public function generateQrCode(Object $newProduct): String
    {
        $generate_qr = SerialNumber::join('ofs', 'serial_numbers.of_id', '=', 'ofs.id')
            ->join('calibers', 'ofs.caliber_id', '=', 'calibers.id')
            ->join('products', 'calibers.product_id', '=', 'products.id')
            ->join('sections', 'products.section_id', '=', 'sections.id')
            ->where('serial_numbers.id', $newProduct->id)
            ->orderBy('serial_numbers.id', 'desc')
            ->first([DB::raw("CONCAT_WS('#',ofs.of_code,ofs.of_number,calibers.caliber_name,serial_number, serial_numbers.updated_at) as qr")]);

        $newProduct->update(['qr' => $generate_qr->qr]);

        return $newProduct->qr;
    }
}
