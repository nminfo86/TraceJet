<?php

namespace App\Http\Controllers\Api\v1;




use App\Models\Caliber;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreCaliberRequest;
use App\Http\Requests\UpdateRequests\UpdateCaliberRequest;



class CaliberController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:caliber-list', ['only' => ['index']]);
        $this->middleware('permission:caliber-create', ['only' => ['store']]);
        $this->middleware('permission:caliber-edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:caliber-delete', ['only' => ['destroy']]);
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
    public function store(StoreCaliberRequest $request)
    {
        $section = Caliber::create($request->all());

        //Send response with success
        return $this->sendResponse($this->success_msg, $section);
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
    public function update(UpdateCaliberRequest $request, Caliber $caliber)
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
