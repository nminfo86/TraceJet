<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Of;
use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Events\CreateOFEvent;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreOfRequest;
use App\Http\Requests\UpdateRequests\UpdateOfRequest;

class OfController extends Controller
{
    use ResponseTrait;

    function __construct()
    {
        $this->middleware('permission:of-list', ['only' => ['index']]);
        $this->middleware(['permission:of-create', 'permission:of-list'], ['only' => ['store']]);
        $this->middleware('permission:of-edit', ['only' => ['show', 'update']]);
        $this->middleware(['permission:of-delete', 'permission:of-list'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ofs = Of::filterBySection()->join('calibers', function ($join) {
            $join->on('calibers.id', '=', 'ofs.caliber_id');
        })->orderBy("ofs.id", "desc")->get(["ofs.id", "of_number", "of_code", "status", "new_quantity", "caliber_name", "updated_at"]);

        //Send response with success
        return $this->sendResponse(data: $ofs);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfRequest $request)
    {
        // Get last OF
        $last_of = Of::filterBySection()->orderBy("id", "desc")->first();

        if ($last_of) {
            // Check if any of in production
            if ($last_of->status == "inProd" && $last_of->caliber_id == $request->caliber_id) {

                // TODO::Trans msg
                //Send response with message
                $msg = __("response-messages.of_duplicate_caliber");
                return $this->sendResponse($msg, status: false);
            }
            $request["of_number"] =    str_pad($last_of->of_number + 1, 3, 0, STR_PAD_LEFT);
        } else {
            $request["of_number"] = "001";
        }

        // store in db
        $of = Of::create($request->all());

        // This event generated of_code
        event(new CreateOFEvent($of));

        //Send response with success
        $msg = __("response-messages.success");
        return $this->sendResponse($msg, $of);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ofs  $ofs
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $of = Of::with("caliber:id,product_id")->findOrFail($id, ["of_name", "caliber_id", "status", "quantity", "new_quantity"]);
        //Send response with data
        return $this->sendResponse(data: $of);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ofs  $ofs
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfRequest $request, Of $of)
    {

        $of->update($request->all());

        // update of_code using procedure in db
        if ($of) {
            event(new CreateOFEvent($of));
        }

        //Send response with success
        $msg = __("response-messages.success");
        return $this->sendResponse($msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ofs  $ofs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Of $of)
    {
        $of->delete();

        //Send response with success
        return $this->sendResponse($this->delete_success_msg);
    }



    // This function used in serial_numbers blade
    public function getOfDetails($id)
    {
        // Get of information
        $of_info = Of::join('calibers', 'ofs.caliber_id', 'calibers.id')
            ->join('products', 'calibers.product_id', 'products.id')
            ->find($id, ["calibers.caliber_name", "products.product_name", "ofs.release_date", "ofs.of_number", "ofs.new_quantity", 'ofs.status']);

        return $of_info;
    }


    /**
     * ofStatistic this method used called on dashboard
     *
     * @param  Int $id
     *  @return \Illuminate\Http\Response
     */
    public function ofStatistics($id)
    {
        // Récupérer l'OF avec ses numéros de série et les informations de son calibre et du produit associé
        $of = Of::with([

            'caliber.product.section.posts' => fn ($q) =>
            $q->orderBy("posts_type_id")
                ->with('posts_type')
                ->select('id', 'post_name', 'code', 'section_id', 'color', 'posts_type_id')
                ->withCount('movements')
        ])
            ->select('id', 'of_number', 'of_name', 'status', 'new_quantity', 'caliber_id', 'release_date')
            ->find($id);;
        $posts = $of->caliber->product->section->posts;
        $quantity = $of->new_quantity;
        $posts->map(function ($post) use ($quantity) {
            $post->movement_percentage = $post->movements_count / $quantity * 100;
            $post->stayed = 100 - $post->movement_percentage;
            return $post;
        });


        // Retrieve all serial numbers with their latest movements and associated posts
        $serialNumbers = serialNumber::with(['movements' => function ($query) {
            $query->latest('created_at')
                ->select('id', 'serial_number_id', 'result', 'created_at', 'movement_post_id')
                ->with('posts:id,post_name,color');
        }])->where([['of_id', $of->id], ["valid", 1]])->get()
            // Group serial numbers by their serial number
            ->groupBy('serial_number')
            // Map the grouped serial numbers to a new format with the latest movement and associated post
            ->map(function ($group) {
                $lastMovement = $group->flatMap(function ($serialNumber) {
                    return $serialNumber['movements'];
                })
                    ->sortByDesc('created_at')
                    ->first();

                return [
                    'id' => $group->first()['id'],
                    // 'serial_number' => $group->first()['serial_number'],
                    'qr' => $group->first()['qr'],
                    // 'result' => $lastMovement['result'] ?? null,
                    'post' => $lastMovement['posts']['post_name'] ?? null,
                    'color' => $lastMovement['posts']['color'] ?? null,
                ];
            })->values()->all();

        /* -------------------------------------------------------------------------- */
        /*                               Taux avancement                              */
        /* -------------------------------------------------------------------------- */
        $section_id = $of->caliber->product->section_id;
        $count = Movement::join('posts', 'movements.movement_post_id', '=', 'posts.id')
            ->where('posts.section_id', '=', $section_id)
            ->where('posts.posts_type_id', '=', 3)
            ->count('movements.serial_number_id');
        $of->taux =  $count / $quantity * 100 . "%";
        // return $serialNumbers;
        return   compact("of", "serialNumbers");
    }
}
