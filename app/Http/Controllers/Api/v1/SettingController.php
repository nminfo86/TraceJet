<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $inputs = $request->all();

        // Handle the image upload
        if ($request->hasFile('logo')) {

            $file = $request->logo;
            $path = 'images/company/';
            // Generate a unique filename for the uploaded image
            $image_name = $path . time() . '_' . $file->getClientOriginalName();
            // Move the uploaded file to the public disk storage
            $file->move(public_path($path), $image_name);

            // Save the image path in the database
            $inputs['logo'] = $image_name;
        }
        // dd($request->logo);

        $setting = Setting::create($inputs);

        //Send response with success
        return $this->sendResponse($this->create_success_msg, $setting);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //Send response with success
        return $this->sendResponse(data: $setting);
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
    public function destroy(Setting $setting)
    {
        $setting->delete();

        //Send response with success
        return $this->sendResponse($this->delete_success_msg);
    }
}