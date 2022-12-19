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

    // [ ]::Opinion of frontman
    public function index()
    {
        $data['serialNumber '] = SerialNumber::get();
        $data['ofs_list'] = Of::pluck('of_number', 'id');


        // $serialNumber = SerialNumber::join('ofs', 'serial_numbers.of_id', 'ofs.id')->get();

        //Send response with data
        return $this->sendResponse(data: $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSerialNumberRequest $request)
    {

        // Count sn by ofs
        $count = SerialNumber::where('of_id', $request->of_id)->count();

        if ($count === 0) {

            // Generate first sn
            $request['serial_number'] = "SN0" . 1;
            $create_first_record = SerialNumber::create($request->except('of_quantity'));

            if ($create_first_record) {
                $of = Of::findOrFail($create_first_record->of_id);
                $of->update(['status' => 'inProd']);
            }


            //Send response with success
            return $this->sendResponse($this->success_msg, $create_first_record);
        }
        //Send response with success
        return $this->sendResponse("Record already exist", status: false);
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

    public function checkQr(Request $request, SerialNumber $serialNumber)
    {
        // $ex=str($request->qr)->explode('#');
        // Check qr
        $find_by_qr = SerialNumber::where('of_id', $request->of_id)->where('qr', $request->qr)->first();

        if ($find_by_qr && $find_by_qr->valid == 0) {

            // Update valid
            $find_by_qr->update(['valid' => 1]);

            // Count sn by of
            $count = SerialNumber::where('of_id', $request->of_id)->valid(1)->count();


            if ($count < $request->of_quantity) {

                // Increment SN
                $find_by_qr->serial_number++;

                // Create new record (next serial number)
                $new_record = $serialNumber->create([
                    "of_id" => $find_by_qr->of_id,
                    "serial_number" => $find_by_qr->serial_number++,
                ]);
                if ($new_record) {

                    //Send response with success
                    return $this->sendResponse($this->success_msg, $new_record);
                }
            }

            // Change of table status to closed
            // $of = Of::findOrFail($find_by_qr->of_id);
            // $of->update(['status' => 'closed']);

            //Send response with success
            return $this->sendResponse("All product OF has been generated");
        }

        // Send response with error
        return $this->sendResponse("Error Qr validated or doesn't exist ", status: false);
    }
}
