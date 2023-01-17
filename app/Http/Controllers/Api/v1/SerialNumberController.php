<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreSerialNumberRequest;
use App\Models\Of;
use App\Models\SerialNumber;
use Illuminate\Http\Request;

class SerialNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $serialNumber = SerialNumber::join('ofs', 'serial_numbers.of_id', 'ofs.id')
            ->where("serial_numbers.of_id", $request->of_id)
            ->get(["of_code", "serial_numbers.id", "serial_number", "qr"]);

        //Send response with data
        return $this->sendResponse(data: $serialNumber);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSerialNumberRequest $request)
    {

        // Check if sn_of_OF exist
        $sn_not_exist = SerialNumber::whereOfId($request->of_id)->doesntExist();

        if ($sn_not_exist) {

            // Generate first sn
            $request['serial_number'] = str_pad(1, 3, 0, STR_PAD_LEFT);
            $create_first_record = SerialNumber::create($request->except('of_quantity'));

            // Update of status
            if ($create_first_record) {
                $of = Of::findOrFail($create_first_record->of_id);
                $of->update(['status' => 'inProd']);
            }
            //Send response with success
            return $this->sendResponse($this->create_success_msg, $create_first_record);
        }
        //Send response with success
        return $this->sendResponse("Serial number already exist", status: false);
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

    public function checkQr(Request $request)
    {
        // $ex=str($request->qr)->explode('#');
        // Check qr
        $product = SerialNumber::where('of_id', $request->of_id)->where('qr', $request->qr)->first();

        if ($product && $product->valid == 0) {

            // Update valid
            $product->update(['valid' => 1]);

            // Create new serial number after updated last record to valid=1
            return $this->CreateNextSN($request, $product);
        }

        // Send response with error
        return $this->sendResponse("Product validated or doesn't exist", status: false);
    }


    public function CreateNextSN($request, $product)
    {
        // Count validated SN product  by of
        $count = SerialNumber::where('of_id', $request->of_id)->valid(1)->count();

        if ($count < $request->of_quantity) {
            // Increment SN
            $product->serial_number++;



            // Create new sn (next serial number)
            $new_sn = SerialNumber::create([
                "of_id" => $product->of_id,
                // "serial_number" => $product->serial_number++,
                "serial_number" =>  str_pad($product->serial_number++, 3, 0, STR_PAD_LEFT),
            ]);

            //Send response with success
            return $this->sendResponse($this->create_success_msg, $new_sn);
        }

        //Send response with error
        return $this->sendResponse("All products has been generated");
    }
}