<?php

namespace App\Http\Controllers\Api\api_v1;


use App\Models\Caliber;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;

class CaliberController extends Controller
{
    use ResponseTrait;
    function __construct()
    {
        // $this->middleware('permission:product-list', ['only' => ['index']]);
        // $this->middleware('permission:product-create', ['only' => ['store']]);
        // $this->middleware('permission:product-edit', ['only' => ['show', 'update']]);
        // $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Caliber::with('product')->get();

        //Send response with success
        return $this->sendResponse(data: $sections);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $section = Caliber::create($request->all());

        //Send response with success
        return $this->sendResponse("Created successfully", $section);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caliber  $caliber
     * @return \Illuminate\Http\Response
     */
    public function show(Caliber $caliber)
    {
        return $this->sendResponse(data: $caliber);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Caliber  $caliber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caliber $caliber)
    {
        $caliber->update($request->all());

        //Send response with success
        return $this->sendResponse("Updated successfully", $caliber);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caliber  $caliber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caliber $caliber)
    {
        $caliber->delete();

        //Send response with success
        return $this->sendResponse("Deleted successfully");
    }
}