<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Of;
use App\Models\Movement;
use Illuminate\Support\Arr;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreSerialNumberRequest;

class SerialNumberController extends Controller
{

    public function getValidSn()
    {
        return SerialNumber::whereValid(1)->get(["serial_number", "qr"]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // Get of information
        $of_info = Of::join('calibers', 'ofs.caliber_id', 'calibers.id')
            ->join('products', 'calibers.product_id', 'products.id')
            ->find($request->of_id, ["calibers.caliber_name", "products.product_name", "ofs.created_at", "ofs.of_number", "ofs.quantity", 'ofs.status']);

        // Get valid serialNumbers of  OF
        // $of_info['sn_list'] = $this->getValidSn();

        // $qty=Movement::where("ofs.")

        /*$of_info['sn_list'] = Movement::rightJoin('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->join('ofs', 'serial_numbers.of_id', 'ofs.id')
            ->where(function ($query) {
                // FIXME:: replace 1 with post_id
                $query->where("movements.movement_post_id", '=', 1)
                    ->orWhere("movements.movement_post_id", '=', null);
            })->where("serial_numbers.of_id", $request->of_id)
            ->get(["serial_numbers.id", "serial_number", "qr", "valid"]);*/

        // $of_info['count'] = $of_info['sn_list']->count();
        return $this->sendResponse(data: $of_info);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StoreSerialNumberRequest $request)
    // {

    //     // Check if sn_of_OF exist
    //     $sn_not_exist = SerialNumber::whereOfId($request->of_id)->doesntExist();

    //     if ($sn_not_exist) {

    //         // Generate first sn
    //         $request['serial_number'] = str_pad(1, 3, 0, STR_PAD_LEFT);
    //         $create_first_record = SerialNumber::create($request->except('of_quantity'));

    //         // Update of status
    //         if ($create_first_record) {
    //             $of = Of::findOrFail($create_first_record->of_id);
    //             $of->update(['status' => 'inProd']);
    //         }
    //         //Send response with success
    //         return $this->sendResponse($this->create_success_msg, $create_first_record);
    //     }
    //     //Send response with success
    //     return $this->sendResponse("Serial number already exist", status: false);
    // }

    //valid product
    public function store(StoreSerialNumberRequest $request)
    {

        // $ex=str($request->qr)->explode('#');
        // Check qr
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SerialNumber  $serialNumber
     * @return \Illuminate\Http\Response
     */
    public function show(SerialNumber $serialNumber)
    {
        //Send response with success
        return $this->sendResponse(data: $serialNumber);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SerialNumber  $serialNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SerialNumber $serialNumber)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SerialNumber  $serialNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(SerialNumber $serialNumber)
    {
        //
    }


    // public function CreateNextSN($request, $product)
    // {
    //     // Count validated SN product  by of
    //     $count = SerialNumber::where('of_id', $request->of_id)->valid(1)->count();

    //     if ($count < $request->of_quantity) {
    //         // Increment SN
    //         $product->serial_number++;



    //         // Create new sn (next serial number)
    //         $new_sn = SerialNumber::create([
    //             "of_id" => $product->of_id,
    //             // "serial_number" => $product->serial_number++,
    //             "serial_number" =>  str_pad($product->serial_number++, 3, 0, STR_PAD_LEFT),
    //         ]);

    //         //Send response with success
    //         return $this->sendResponse($this->create_success_msg, $new_sn);
    //     }

    //     //Send response with error
    //     return $this->sendResponse("All products has been generated");
    // }


    public function PrintQrCode(Request $request)
    {
        $sn_not_exist = SerialNumber::whereOfId($request->of_id)->doesntExist();

        if ($sn_not_exist) {
            // Generate first sn
            $request['serial_number'] = str_pad(1, 3, 0, STR_PAD_LEFT);
            $create_first_record = SerialNumber::create($request->all());
            //Send response with success
            return $this->sendResponse("The QR code has printed", $create_first_record);
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

        //Send response with success
        return $this->sendResponse($this->create_success_msg, $new_sn);
    }
}