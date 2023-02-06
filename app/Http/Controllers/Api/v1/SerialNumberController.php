<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Of;
use App\Models\Movement;
use Illuminate\Support\Arr;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreSerialNumberRequest;
use App\Traits\ResponseTrait;
use Carbon\Carbon;

class SerialNumberController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // TODO::add of status codition new & inProd
        // Get serial numbers valid list
        $sn_valid_list['list'] = SerialNumber::whereOfId($request->of_id)->whereValid(1)->get(["id", "serial_number", "qr", "of_id", "created_at"]);
        // update of status in first valid action
        if ($sn_valid_list['list']->count() == 1) {
            $of = Of::findOrFail($sn_valid_list['list'][0]->of_id);
            $of->update(['status' => 'inProd']);
            // this kay for update staus of of in blade
            $sn_valid_list["status"] = "inProd";
        }

        // Quantity of day
        $sn_valid_list['quantity_of_day'] = $sn_valid_list['list']->filter(function ($item) {
            return $item['created_at'] == Carbon::today()->toDateString();
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
        // Check qr in db
        $product = SerialNumber::whereOfId($request->of_id)->whereQr($request->qr)->whereValid(0)->first();

        if ($product) {
            // Valid product
            $product->update(['valid' => 1]);

            // Create new sn (next serial number)
            return $this->createNextSN($request->of_id);
        }
        // Send response with error
        return $this->sendResponse("Product already valid Or not belong to current prod", status: false);
    }

    public function PrintQrCode(Request $request)
    {
        $this->create_success_msg = "The QR code has printed";
        $sn_not_exist = SerialNumber::whereOfId($request->of_id)->doesntExist();

        if ($sn_not_exist) {

            // Generate first sn
            $request['serial_number'] = str_pad(1, 3, 0, STR_PAD_LEFT);
            $create_first_record = SerialNumber::create($request->all());

            //Send response with success
            return $this->sendResponse($this->create_success_msg, $create_first_record->only('qr'));
        }

        return $this->createNextSN($request->of_id);
    }

    public function createNextSN($of_id)
    {
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
    }
}