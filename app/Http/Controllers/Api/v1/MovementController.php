<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Box;
use App\Models\Post;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class MovementController extends Controller
{



    function __construct()
    {
        $this->middleware('permission:movement-list', ['only' => ['index']]);
        $this->middleware('permission:movement-create', ['only' => ['store']]);
        $this->middleware('permission:movement-edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:movement-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movement = Movement::get();

        //Send response with success
        return $this->sendResponse(data: $movement);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get current post information by mac_address for check previous post
        $post = $this->getCurrentPostInformation($request->mac);

        // Get last movement of QR and create movement or packaging action
        return $this->createNextStep($request, $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movement $movement
     * @return \Illuminate\Http\Response
     */
    public function show(Movement $movement)
    {
        //Send response with success
        return $this->sendResponse(data: $movement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movement $movement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movement $movement)
    {
        $movement->update($request->all());

        //Send response with success
        return $this->sendResponse("Updated successfully", $movement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movement $movement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movement $movement)
    {
        $movement->delete();

        //Send response with success
        return $this->sendResponse("Deleted successfully");
    }


    /**
     * Get current post information.
     *
     * @param  $mac_address from request
     * @return \Illuminate\Http\Response
     */
    public function getCurrentPostInformation($mac_address)
    {
        $post = Post::where('mac', $mac_address)->firstOrFail(); // [x]::add exeption of packaging posts
        if ($post->previous_post == NULL) {
            //Send response with message
            return $this->sendResponse("Cannot create in this post", status: false);
        }
        return $post;
    }

    /**
     * Get last product movement.
     *
     * @param [array] $request
     * @param [array] $post
     * @return \Illuminate\Http\Response
     */
    public function createNextStep($request, $post)
    {
        $last_movement = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('serial_numbers.qr',  $request->qr)
            ->latest()->first(['movements.id', 'previous_post_id', 'qr', 'serial_number_id', 'result']);

        // Not exist
        if (!$last_movement) {
            //Send response with error
            return $this->sendResponse('QR does not belong to the current OF', status: false);
        } else {


            return $this->checkProductSteps($request, $last_movement, $post);
        }
    }

    /**
     * Verify result and last steps of product in production
     *
     * @param [array] $request
     * @param [array] $last_movement
     * @param [array] $post
     * @return \Illuminate\Http\Response

     */
    public function checkProductSteps($request, $last_movement, $post)
    {
        if ($last_movement->previous_post_id == $post->id) {

            //Send response with error
            return $this->sendResponse('QR has been already exists', status: false);
        }

        // Check result
        if ($last_movement->result !== 'ok') {

            //Send response with error
            return $this->sendResponse('Transfer to repairer', status: false);
        }

        // Check Post order
        if ($last_movement->previous_post_id != $post->previous_post) {

            //Send response with error
            return $this->sendResponse('Check posts order', status: false);
        }

        return $this->newMovementOrPackagingAction($request, $last_movement, $post->id);
    }


    /**
     * this method check last movement of product and create next movement,if next movement is packaging create new box
     *
     * @param [array] $request
     * @param [array] $last_movement
     * @param [integer] $post_id
     * @return \Illuminate\Http\Response
     */
    public function newMovementOrPackagingAction($request, $last_movement, $post_id)
    {
        // Count operating post
        $operator_post_count = Post::where('posts_type_id', 2)->count();

        // Count Movement of QR
        $product_movements = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('qr', $request->qr)
            ->get();

        // Create new movement
        if ($product_movements->count() <= $operator_post_count) {
            return  $this->createMovement($request->result, $last_movement->serial_number_id, $post_id);
        }

        // Create last movement (packaging) and boxing
        if ($product_movements->count() === $operator_post_count + 1) {

            return $this->createMovement($request->result, $last_movement->serial_number_id, $post_id, true, $product_movements);
        }
    }

    /**
     * Create movement and packaging operation
     *
     * @param [string] $result
     * @param [integer] $sn_id
     * @param [integer] $post_id
     * @param boolean $packaging
     * @param array $product_movements
     * @return void
     */
    public function createMovement($result, $sn_id, $post_id, $packaging = false, $product_movements = [])
    {
        // Prepare movement inputs
        $inputs = [
            'serial_number_id'      => $sn_id,
            'previous_post_id'      => $post_id,
            // 'previous_post_name'    => $post->post,
            'result'                => $result,

        ];

        if ($packaging) {
            // try {
            // DB::beginTransaction();
            $this->createMovement($result, $sn_id, $post_id);
            $box = Box::create(['of_id' => $product_movements[0]['of_id'], "status" => "open", "box_qr" =>  $product_movements[0]['serial_number']]);

            //Send response with success
            return $this->sendResponse("Created successfully", $box);
            // DB::commit();
            // } catch (\Exception $e) {
            //     DB::rollBack();
            // }
        }

        // Create new movement
        $movement = Movement::create($inputs);
        //Send response with success
        return $this->sendResponse("Created successfully", $movement);
    }
}