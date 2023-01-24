<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Of;
use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
        $explode = str($request->qr)->explode('#');

        $data = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->join('ofs', 'serial_numbers.of_id', 'ofs.id')
            ->join('calibers', 'ofs.caliber_id', 'ofs.id')
            ->join('boxes', 'serial_numbers.box_id', 'boxes.id')
            ->whereOfCode($explode[0])
            ->where('serial_numbers.serial_number', $explode[2])
            ->whereMovementPostId(2)->first(["ofs.of_code", "ofs.status", "ofs.created_at as of_creation_date", "boxes.box_qr", "boxes.status as box_status", "calibers.box_quantity", "calibers.caliber_name", "serial_numbers.id as sn_id"]);
        if (!$data) {
            $of_id = Of::find(1)->id;
            $sn_id = SerialNumber::whereSerialNumber($explode[2])->first()->id;
            try {
                DB::beginTransaction();

                // Create movement
                $this->createMovement($request->result, 1, 2);
                $this->boxingAction($of_id, $sn_id);
                DB::commit();

                // return   $this->closeOf($of_id);
                //Send response with success
                return $this->sendResponse($this->create_success_msg);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
        return $data;
    }

    /**
     * Create movement and packaging operation
     *
     * @param [string] $result
     * @param [integer] $sn_id
     * @param [integer] $post_id
     * @param boolean $packaging
     * @param array $product_movements
     * @return void
     */
    public function createMovement(String $result, Int $sn_id, Int $post_id, $packaging = false,  $product_movements = [])
    {

        // Create (packaging movement,boxes and update serial number table)
        if ($packaging && !empty($product_movements)) {
            $of_id = $product_movements[0]['of_id'];
            try {
                DB::beginTransaction();

                // Create movement
                $this->createMovement($result, $sn_id, $post_id);
                $this->boxingAction($of_id, $sn_id);
                DB::commit();

                // return   $this->closeOf($of_id);
                //Send response with success
                return $this->sendResponse($this->create_success_msg);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        // Prepare movement inputs
        $inputs = [
            'serial_number_id'      => $sn_id,
            'movement_post_id'      => $post_id,
            'result'                => $result,
        ];
        // Create new movement
        $movement = Movement::create($inputs);


        //Send response with success
        return $this->sendResponse($this->create_success_msg, $movement);
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