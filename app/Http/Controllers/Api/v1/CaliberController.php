<?php

namespace App\Http\Controllers\Api\v1;




use App\Models\Caliber;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreCaliberRequest;
use App\Http\Requests\UpdateRequests\UpdateCaliberRequest;



class CaliberController extends Controller
{
    use ResponseTrait;

    function __construct()
    {
        $this->middleware('permission:caliber-list', ['only' => ['index']]);
        $this->middleware(['permission:caliber-create', 'permission:caliber-list'], ['only' => ['store']]);
        $this->middleware('permission:caliber-edit', ['only' => ['show', 'update']]);
        $this->middleware(['permission:caliber-delete', 'permission:caliber-list'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $calibers = Caliber::with('product')->get();
        $calibers = Caliber::join('products', function ($join) {
            $join->on('calibers.product_id', '=', 'products.id');
        })->get(["calibers.id", "caliber_code", "caliber_name", "box_quantity", "product_name"]);
        // //Send response with success
        return $this->sendResponse(data: $calibers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCaliberRequest $request)
    {
        $caliber = Caliber::create($request->all());

        //Send response with success
        $msg = $this->getResponseMessage("success");
        return $this->sendResponse($msg, $caliber);
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
        $msg = $this->getResponseMessage("success");
        return $this->sendResponse($msg, $caliber);
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
        $msg = $this->getResponseMessage("success");
        return $this->sendResponse($msg);
    }
}
