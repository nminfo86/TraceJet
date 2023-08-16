<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Movement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\MovementService;

class MovementController extends Controller
{
    private $movementService;
    function __construct(MovementService $movementService)
    {
        $this->movementService = $movementService;
        $this->middleware('permission:movement-list', ['only' => ['index']]);
        $this->middleware(['permission:movement-create', 'permission:movement-list'], ['only' => ['store']]);
        $this->middleware('permission:movement-edit', ['only' => ['show', 'update']]);
        $this->middleware(['permission:movement-delete', 'permission:movement-list'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movement = Movement::get();
        //Send response with success
        return $this->sendResponse(data: $movement);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get last movement of QR and create movement or packaging action
        return $this->movementService->nextStep($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movement $movement
     * @return \Illuminate\Http\Response
     */
    public function show(Movement $movement)
    {
        //Send response with success
        return $this->sendResponse(data: $movement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movement $movement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movement $movement)
    {
        $movement->update($request->all());

        //Send response with success
        return $this->sendResponse($this->update_success_msg, $movement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movement $movement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movement $movement)
    {
        $movement->delete();

        //Send response with success
        $msg = $this->getResponseMessage("success");
        return $this->sendResponse($msg);
    }
}
