<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Printer;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class PrinterController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $printers = Printer::with('section:id,section_name')->get();

        return  $this->sendResponse(data: $printers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Printer::create($request->all());

        //Send response with success
        $msg = __('response-messages.success');
        return $this->sendResponse($msg, $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Printer  $printer
     * @return \Illuminate\Http\Response
     */
    public function show(Printer $printer)
    {
        //Send response with success
        return $this->sendResponse(data: $printer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Printer  $printer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Printer $printer)
    {
        $printer->update($request->all());

        //Send response with success
        $msg = __('response-messages.success');
        return $this->sendResponse($msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Printer  $printer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Printer $printer)
    {
        $printer->delete();

        //Send response with success
        $msg = __('response-messages.success');
        return $this->sendResponse($msg);
    }
}
