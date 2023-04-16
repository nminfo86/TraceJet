<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Of;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreSerialNumberRequest;
use Carbon\Carbon;
use App\Services\PrintLabelService;

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
        // return $valid_qr;
        if ($product['list']->count() == 1) {

            // this kay for update status of of in blade
            $of = Of::findOrFail($request->of_id, ["id", "status"]);

            // update of status in first valid action
            $of->update(['status' => 'inProd']) ? $product["status"] = "inProd" : "";
        }

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

        // get invalid product with QR code
        $product = SerialNumber::with("of:id,new_quantity")->whereQr($request->qr)->whereValid(0)->first();

        // Check qr in db
        if (!$product) {
            $msg = $this->getResponseMessage("not_found", ["attribute" => "product"]);
            return $this->sendResponse($msg, status: false);
        }

        $of_quantity = $product->of->new_quantity;
        // Valid product
        $product->update(['valid' => 1]);

        // Create new sn (next serial number)
        return $this->generateNewSN($request->of_id, $of_quantity);
    }


    public function generateNewSN($of_id, $of_quantity)
    {


        // Check with OF quantity
        if ($of_quantity <= $this->countValidProducts($of_id)) {

            $msg = $this->getResponseMessage("of_closed");
            //Send response with Error
            return $this->sendResponse($msg, status: false);
        }

        // Get last sn by of_id
        $product = SerialNumber::whereOfId($of_id)->orderBy("id", "desc")->first();

        // Increment SN
        $product->serial_number++;

        // Create new sn (next serial number)
        $new_sn = SerialNumber::create([
            "of_id" => $product->of_id,
            "serial_number" =>  str_pad($product->serial_number++, 3, 0, STR_PAD_LEFT),
        ]);

        //Send response with QR success
        $msg = $this->getResponseMessage("print_qr-success");
        return $this->sendResponse($msg, $new_sn->only('qr'));
    }

    public function PrintQrCode(Request $request)
    {
        $product = SerialNumber::whereOfId($request->of_id)->exists();

        if (!$product) {

            // Generate first product QR
            $request['serial_number'] = str_pad(1, 3, 0, STR_PAD_LEFT);
            $create_first_record = SerialNumber::create($request->all());

            //Send response with success
            $msg = $this->getResponseMessage("print_qr-success");
            return $this->sendResponse($msg, $create_first_record->only('qr'));
        }

        $of_quantity = Of::findOrFail($request->of_id, ["new_quantity"])->new_quantity;
        return $this->generateNewSN($request->of_id, $of_quantity);
    }





    public function countValidProducts($of_id)
    {
        return SerialNumber::whereOfId($of_id)->whereValid(1)->count();
    }
}
