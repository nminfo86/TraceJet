<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Movement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SerialNumber;

class PackagingController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $explode = str($request->qr)->explode('#');

        $data['list'] = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->join('ofs', 'serial_numbers.of_id', 'ofs.id')
            ->join('calibers', 'ofs.caliber_id', 'ofs.id')
            ->whereOfCode($explode[0])
            ->where('calibers.caliber_name', $explode[1])
            ->whereMovementPostId(2)->get(["serial_numbers.serial_number", "movements.created_at"]);

        $data['info'] = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->join('ofs', 'serial_numbers.of_id', 'ofs.id')
            ->join('calibers', 'ofs.caliber_id', 'ofs.id')
            ->join('boxes', 'serial_numbers.box_id', 'boxes.id')
            ->whereOfCode($explode[0])
            ->where('serial_numbers.serial_number', $explode[2])
            ->whereMovementPostId(2)->first(["ofs.of_code", "ofs.status", "ofs.created_at as of_creation_date", "boxes.box_qr", "boxes.status as box_status", "calibers.box_quantity", "calibers.caliber_name"]);

        //Send response with data
        return $this->sendResponse(data: $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $explode = str($request->qr)->explode('#');

        // return $last_movement = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
        //     ->join('ofs', 'serial_numbers.of_id', 'ofs.id')
        //     ->join('boxes', 'serial_numbers.box_id', 'boxes.id')
        //     ->where('ofs.of_code',  $explode[0])
        //     // ->where('serial_numbers.qr',  $request->qr)
        //     // ->where('ofs.status', "inProd")
        //     ->latest("movements.created_at")->first();
    }
    // ['movements.id', 'movement_post_id', 'qr', 'serial_number_id', 'result']

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}