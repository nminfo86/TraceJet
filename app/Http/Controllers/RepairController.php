<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Services\MovementService;

class RepairController extends Controller
{

    private $movementService;
    function __construct(MovementService $movementService)
    {
        $this->movementService = $movementService;
        $this->middleware('permission:movement-list', ['only' => ['index']]);
        $this->middleware('permission:movement-create', ['only' => ['store']]);
        $this->middleware('permission:movement-edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:movement-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return SerialNumber::Has('movement')->with(["movement" => function ($q) {
            $q->where('result', "=", "NOK");
        }])->get();

        // with(["owner", "participants" => function($q) use($someId){
        //     $q->where('participants.IdUser', '=', 1);
        //     //$q->where('some other field', $someId);
        // }])
        // return $this->movementService->productSteps($request->qr)
        // return SerialNumber::with("parts")->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sn = SerialNumber::Has('movement')->with(["movement" => function ($q) {
            $q->where('result', "=", "NOK");
        }])->whereQr($request->qr)->first();

        $sn->parts()->attach($request->sn);
        return response()->json("success", 200);
    }

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
