<?php

namespace App\Http\Controllers\Api\api_v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $sections = Product::paginate();

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
        $section = Product::create($request->all());

        //Send response with success
        return $this->sendResponse("Created successfully", $section);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->sendResponse(data: $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        //Send response with success
        return $this->sendResponse("Updated successfully", $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        //Send response with success
        return $this->sendResponse("Deleted successfully");
    }
}