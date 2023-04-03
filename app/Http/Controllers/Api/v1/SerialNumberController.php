<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Of;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreSerialNumberRequest;
use App\Traits\ResponseTrait;
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
        $sn_valid_list['list'] = SerialNumber::whereOfId($request->of_id)->whereValid(1)->get(["of_id", "serial_number", "created_at"]);
        // return $sn_valid_list;
        if ($sn_valid_list['list']->count() == 1) {

            // this kay for update staus of of in blade
            $of = Of::findOrFail($sn_valid_list['list'][0]->of_id, ["id", "status"]);

            // update of status in first valid action
            $of->update(['status' => 'inProd']) ? $sn_valid_list["status"] = "inProd" : "";
        }

        // Get quantity of valid product (TODAY)
        $sn_valid_list['quantity_of_day'] = "0" . $sn_valid_list['list']->filter(function ($item) {

            return date('Y-m-d', strtotime($item['created_at'])) == Carbon::today()->toDateString();
            // return $item['created_at']->format('Y-m-d') == Carbon::today()->toDateString();
        })->count();

        return $this->sendResponse(data: $sn_valid_list);
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
        if ($product) {

            $of_quantity = $product->of->new_quantity;

            // Check with OF quantity
            if ($of_quantity <= $this->countValidProducts($request->of_id)) {

                // Send response with error
                return $this->sendResponse("OF Valid", status: true);
            }

            // Valid product
            $product->update(['valid' => 1]);

            // Create new sn (next serial number)
            return $this->generateNewSN($request->of_id, $of_quantity);
        }

        // Send response with error
        return $this->sendResponse("This product valid or does not belong to this OF", status: false);
    }


    public function generateNewSN($of_id, $of_quantity)
    {

        // Check with OF quantity
        if ($of_quantity <= $this->countValidProducts($of_id)) {

            //Send response with Error
            return $this->sendResponse("OF Valid");
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
        return $this->sendResponse($this->create_success_msg, $new_sn->only('qr'));
        // $printLabel = new PrintLabelService("192.168.98.121", "TSPL", "40_20");
        // $qrCode = $new_sn->qr;

        // // 932113600012023#001#CX1000-3#001#2023-02-13 22:17:22
        // $qr = explode("#", $qrCode);
        // $sn = $qr[3];
        // $of_num = $qr[1];
        // $product_name = $qr[2];
        // $printLabel->printProductLabel($qrCode, $of_num, $product_name, $sn);
    }

    public function PrintQrCode(Request $request)
    {

        $product = SerialNumber::whereOfId($request->of_id)->exists();

        if ($product) {
            // Get OF quantity
            $of_quantity = Of::findOrFail($request->of_id, ["new_quantity"])->new_quantity;
            return $this->generateNewSN($request->of_id, $of_quantity);
        }

        // Generate first sn
        $request['serial_number'] = str_pad(1, 3, 0, STR_PAD_LEFT);
        $create_first_record = SerialNumber::create($request->all());

        //Send response with success
        return $this->sendResponse("The QR code has printed", $create_first_record->only('qr'));


        // $printLabel = new PrintLabelService("192.168.98.121", "TSPL", "40_20");
        // $qrCode = $create_first_record->qr;

        // // 932113600012023#001#CX1000-3#001#2023-02-13 22:17:22
        // $qr = explode("#", $qrCode);
        // $sn = $qr[3];
        // $of_num = $qr[1];
        // $product_name = $qr[2];
        // return $printLabel->printProductLabel($qrCode, $of_num, $product_name, $sn);
        // return $this->sendResponse("The QR code has printed", $create_first_record->only('qr'));
    }





    public function countValidProducts($of_id)
    {
        return SerialNumber::whereOfId($of_id)->whereValid(1)->count();
    }
}
