<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Section;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreSectionRequest;
use App\Http\Requests\UpdateRequests\UpdateSectionRequest;

class SectionController extends Controller
{
    // use ResponseTrait;


    function __construct()
    {
        $this->middleware('permission:section-list', ['only' => ['index']]);
        $this->middleware('permission:section-create', ['only' => ['store']]);
        $this->middleware('permission:section-edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:section-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::get();

        //Send response with success
        return $this->sendResponse(data: $sections);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSectionRequest $request)
    {
        $section = Section::create($request->all());

        //Send response with success
        return $this->sendResponse($this->create_success_msg, $section);
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
    public function update(UpdateSectionRequest $request, Section $section)
    {
        $section->update($request->all());

        //Send response with success
        return $this->sendResponse($this->update_success_msg, $section);
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
        return $this->sendResponse($this->delete_success_msg);
    }
}
