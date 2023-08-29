<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreRequests\StoreProductRequest;
use App\Http\Requests\UpdateRequests\UpdateProductRequest;

class ProductController extends Controller
{
    use ResponseTrait;
    function __construct()
    {
        $this->middleware('permission:product-list', ['only' => ['index']]);
        $this->middleware(['permission:product-create', 'permission:product-list'], ['only' => ['store']]);
        $this->middleware('permission:product-edit', ['only' => ['show', 'update']]);
        $this->middleware(['permission:product-delete', 'permission:product-list'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::filterBySection()->get();
        //Send response with data
        return $this->sendResponse(data: $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());

        //Send response with success
        $msg = __('response-messages.success');
        return $this->sendResponse($msg, $product);
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
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());

        //Send response with success
        $msg = __('response-messages.success');
        return $this->sendResponse($msg, $product);
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
        $msg = __('response-messages.success');
        return $this->sendResponse($msg);
    }
}
