<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Part;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parts = Part::get();

        //Send response with success
        return $this->sendResponse(data: $parts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $part = Part::create($request->all());

        //Send response with success
        return $this->sendResponse($this->create_success_msg, $part);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function show(Part $part)
    {
        //Send response with success
        return $this->sendResponse($this->create_success_msg, $part);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Part $part)
    {
        $part->update($request->all());

        //Send response with success
        return $this->sendResponse($this->update_success_msg, $part);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Part $part)
    {
        $part->delete();

        //Send response with success
        return $this->sendResponse($this->delete_success_msg);
    }
}