<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Of;
use Illuminate\Http\Request;
use App\Events\CreateOFEvent;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreOfRequest;
use App\Http\Requests\UpdateRequests\UpdateOfRequest;

class OfController extends Controller
{
    use ResponseTrait;

    function __construct()
    {
        $this->middleware('permission:of-list', ['only' => ['index']]);
        $this->middleware('permission:of-create', ['only' => ['store']]);
        $this->middleware('permission:of-edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:of-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $ofs = Of::with('caliber')->get();
        $ofs = Of::join('calibers', function ($join) {
            $join->on('calibers.id', '=', 'ofs.caliber_id');
        })->orderBy("ofs.id", "desc")->get(["ofs.id", "of_number", "of_code", "status", "quantity", "caliber_name", "updated_at"]);

        //Send response with success
        return $this->sendResponse(data: $ofs);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfRequest $request)
    {
        // Get last OF
        $last_of = Of::orderBy("id", "desc")->first();
        if ($last_of) {

            // Check if any of in production
            if ($last_of->status == "inProd" && $last_of->caliber_id == $request->caliber_id) {
                //Send response with message
                return $this->sendResponse("Can't created, another of in production", status: false);
            }
            $request["of_number"] =  $last_of->of_number + 1;
        } else {
            $request["of_number"] = 1;
        }

        // store in db
        $of = Of::create($request->all());

        // This event generated of_code
        event(new CreateOFEvent($of));

        //Send response with success
        return $this->sendResponse($this->create_success_msg, $of);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ofs  $ofs
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $of = Of::findOrFail($id, ["caliber_id", "status", "quantity"]);
        $of = Of::with("caliber:id,product_id")->findOrFail($id, ["caliber_id", "status", "quantity"]);
        //Send response with data
        return $this->sendResponse(data: $of);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ofs  $ofs
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfRequest $request, Of $of)
    {
        $of->update($request->all());

        // update of_code using procedure in db
        if ($of) {
            event(new CreateOFEvent($of));
        }

        //Send response with success
        return $this->sendResponse($this->update_success_msg, $of);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ofs  $ofs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Of $of)
    {
        $of->delete();

        //Send response with success
        return $this->sendResponse($this->delete_success_msg);
    }



    // This function used in serial_numbers blade
    public function getOfDetails($id)
    {
        // Get of information
        $of_info = Of::join('calibers', 'ofs.caliber_id', 'calibers.id')
            ->join('products', 'calibers.product_id', 'products.id')
            ->find($id, ["calibers.caliber_name", "products.product_name", "ofs.created_at", "ofs.of_number", "ofs.quantity", 'ofs.status']);

        return $of_info;
    }
}