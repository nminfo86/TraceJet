<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Of;
use App\Models\Box;
use App\Models\Caliber;
use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Services\MovementService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PackagingController extends Controller
{
    // use ResponseTrait;
    protected $movementService;

    public function __construct(MovementService $movementService)
    {
        $this->movementService = $movementService;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        // return  SerialNumber::where('serial_numbers.of_id', 1)
        //     // ->where('users.rights', '=', 1)
        //     ->join('boxes', 'serial_numbers.box_id', '=', 'boxes.id')
        //     ->select([
        //         "serial_numbers.of_id",
        //         DB::raw('count(distinct boxes.id) as total_box'),
        //         DB::raw('count(distinct serial_numbers.id) as total_sn'),
        //     ])->groupBy('serial_numbers.of_id')->first();
        // ->groupBy('serial_numbers.of_id');
        // ->orderByDesc('total_referal')->paginate(100);

        // return $explode = str($request->qr)->explode('#');
        return $this->movementService->nextStep($request);
        // $of_code = $explode[0];
    }
    public function storyye(Request $request)
    {
        $explode = str($request->qr)->explode('#');
        $of_code = $explode[0];
        // dd($explode);

        $last_movement = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->join('ofs', 'serial_numbers.of_id', 'ofs.id')
            ->join('calibers', 'ofs.caliber_id', 'calibers.id')
            // ->leftJoin('boxes', 'serial_numbers.box_id', 'boxes.id')
            ->where('serial_numbers.serial_number', $explode[2])
            ->whereOfCode($of_code)
            // ->whereMovementPostId(2)
            // ->get();
            ->first(["ofs.id as of_id", "calibers.box_quantity", "movement_post_id"/*, "ofs.of_code", "ofs.status as of_status", "ofs.created_at as of_creation_date", "boxes.box_qr", "boxes.status as box_status", "calibers.box_quantity", "calibers.caliber_name"*/, "serial_numbers.id as sn_id"]);
        if ($last_movement && $last_movement->movement_post_id === 2) {
            // return $response;
            //Send response with error message
            return $this->sendResponse("This Product already packaged", status: false);
        }

        try {
            DB::beginTransaction();

            // Create movement
            // Prepare movement inputs
            $inputs = [
                'serial_number_id'      => $last_movement->sn_id,
                'movement_post_id'      => $post_id = 2,
                'result'                => $result = "OK",
            ];
            // Create new movement
            $movement = Movement::create($inputs);


            $boxing = $this->boxingAction($last_movement->of_id, $last_movement->sn_id, $last_movement->box_quantity);

            DB::commit();
            return $this->sendResponse($this->create_success_msg, data: $boxing);

            // return   $this->closeOf($of_id);
            //Send response with success
            // return $this->sendResponse($this->create_success_msg);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }




    // ['movements.id', 'movement_post_id', 'qr', 'serial_number_id', 'result']


}