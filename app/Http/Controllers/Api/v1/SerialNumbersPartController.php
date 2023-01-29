<?php

namespace App\Http\Controllers\Api\v1;



use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Models\SerialNumbersPart;
use App\Http\Controllers\Controller;

class SerialNumbersPartController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SerialNumbersPart::get();

        //Send response with success
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SerialNumbersPart  $serialNumbersPart
     * @return \Illuminate\Http\Response
     */
    public function show(SerialNumbersPart $serialNumbersPart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SerialNumbersPart  $serialNumbersPart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SerialNumbersPart $serialNumbersPart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SerialNumbersPart  $serialNumbersPart
     * @return \Illuminate\Http\Response
     */
    public function destroy(SerialNumbersPart $serialNumbersPart)
    {
        //
    }
}