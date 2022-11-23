<?php

namespace App\Http\Controllers\Api\api_v1;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::paginate();

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
        return Section::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //Send response with success
        return $this->sendResponse(data: $section);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $section->update($request->all());

        //Send response with success
        return $this->sendResponse("Updated successfully", $section);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();

        //Send response with success
        return $this->sendResponse("Deleted successfully");
    }
}