<?php

namespace App\Services;

use App\Http\Controllers\Api\v1\OfController;
use App\Models\Of;
use App\Models\Box;
use App\Models\Post;
use App\Models\Caliber;
use App\Models\Movement;
use Illuminate\Support\Arr;
use App\Models\SerialNumber;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class MovementService //extends Controller
{
    use ResponseTrait;
    /**
     * Get last product movements.
     *
     * @param [array] $request
     * @param [array] $post
     * @return \Illuminate\Http\Response
     */
    public function nextStep($request)
    {
        // Get last movement of QR and create movement or packaging action
        $last_movement = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->join('ofs', 'serial_numbers.of_id', 'ofs.id')
            ->join('calibers', 'ofs.caliber_id', 'calibers.id')
            ->where('serial_numbers.qr',  $request->qr)
            ->where('ofs.status', "inProd")
            ->latest("movements.created_at")->first(['movement_post_id', 'serial_numbers.of_id', 'qr', 'serial_number_id', 'result', 'caliber_name', 'box_quantity']);

        // Not exist
        if (!$last_movement) {
            //Send response with error
            return $this->sendResponse('Product does not belong to the current OF', status: false);
        }
        return $this->productStepsControl($request, $last_movement);
    }

    /**
     * Get current post information.
     *
     * @param  $mac_address from request
     * @return \Illuminate\Http\Response
     */
    public function getCurrentPostInformation(string $mac_address)
    {
        $post = Post::whereMac($mac_address)->firstOrFail();
        return $post;
    }


    /**
     * Verify result and last steps of product in production
     *
     * @param [Object] $request
     * @param [Object] $last_movement
     * @param [Object] $post
     * @return \Illuminate\Http\Response

     */
    public function productStepsControl(Object $request, Object $last_movement)
    {
        // Get current post information by mac_address for check previous post
        $post = $this->getCurrentPostInformation($request->mac);

        // movement exist with this post
        if ($last_movement->movement_post_id == $post["id"]) {
            //Send response with error
            return $this->sendResponse('Product already executed on this post', status: false);
        }

        // Get name of last post executed
        $post_name = Post::findOrFail($last_movement->movement_post_id)->post_name;


        /* -------------------------------------------------------------------------- */
        /*                           Reparation Post Section                          */
        /* -------------------------------------------------------------------------- */
        // Check result if Nok in last movement
        if ($last_movement->result == 'NOK') {

            // # Reparation post_type_id = 4
            // if ($post->posts_type_id === 4) {

            //     $last_movement->update(["result" => "rebut"]);
            //     //Send response with data
            //     return $this->sendResponse("Product destroyed");
            // }
            //Send response with error
            return $this->sendResponse("Product NOK on, $post_name", status: false);
        }



        /* -------------------------------------------------------------------------- */
        /*                            Packaging post action                           */
        /* -------------------------------------------------------------------------- */
        //Get packaging posts ids
        $packaging_posts = $this->getPackagingPostsIds()->toArray();

        // keep only values from array
        $ids = Arr::flatten($packaging_posts);

        if (in_array($last_movement->movement_post_id, $ids))
            return $this->sendResponse("Product packaged", status: false);

        // Check last step of product
        if ($last_movement->movement_post_id != $post["previous_post_id"]) {
            //Send response with error
            return $this->sendResponse("The last step for this product was on , $post_name", status: false);
        }

        // Create next step
        return $this->newMovementOrPackagingAction($request, $last_movement, $post["id"]);
    }



    /**
     * this method check last movement of product and create next movement,if next movement is packaging created and create new box
     *
     * @param [Object] $request
     * @param [Object] $last_movement
     * @param [integer] $post_id
     * @return \Illuminate\Http\Response
     */
    public function newMovementOrPackagingAction(Object $request, Object $last_movement, int $post_id)
    {
        // Count operator posts
        $operator_post_count = $this->countOperatorPosts();

        // Get Movement of Product
        $product_movements = $this->productSteps($request->qr);
        // return [$last_movement, $product_movements];

        // Create new movement
        if ($product_movements/*->count()*/ <= $operator_post_count) {
            return  $this->createMovement($request->result, $last_movement, $post_id);
        }

        // Create last movement (packaging) and boxing
        if ($product_movements/*->count()*/  === $operator_post_count + 1) {

            return $this->createMovement($request->result, $last_movement/*->serial_number_id, $last_movement->serial_number*/, $post_id, true/*, $product_movements*/);
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
    public function createMovement(String $result, $last_movement, $post_id, $packaging = false /*Int $sn_id, $qr, Int $post_id, $packaging = false,  $product_movements = []*/)
    {
        // return $last_movement;
        // return $last_movement;

        // Create (packaging movement,boxes and update serial number table)
        if ($packaging && !empty($last_movement)) {
            // $of_id = $product_movements[0]['of_id'];
            // $of_id = $last_movement->of_id;
            // dd($last_movement->serial_number_id);
            try {
                DB::beginTransaction();

                // Create movement
                // $this->createMovement($result, $sn_id, $post_id);
                // $msg = $this->boxingAction($of_id, $sn_id, $qr);
                $this->createMovement($result, $last_movement, $post_id);
                $response = $this->boxingAction($last_movement);
                DB::commit();

                // return   $this->closeOf($of_id);
                //Send response with success
                return $this->sendResponse(data: $response);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
        // Prepare movement inputs
        // dd($last_movement->serial_number_id);

        $inputs = [
            'serial_number_id'      => $last_movement->serial_number_id,
            'movement_post_id'      => $post_id,
            'result'                => $result,
        ];
        // Create new movement
        $movement = Movement::create($inputs);


        //Send response with success
        return $this->sendResponse($this->create_success_msg, $movement);
    }


    public function boxingAction(/*int $of_id, String $sn_id, $qr*/$last_movement)
    {
        $of_id = $last_movement->of_id;
        $sn_id = $last_movement->serial_number_id;
        $box_quantity = $last_movement->box_quantity;
        // Get Last box opened
        $last_open_box = Box::where('of_id', $of_id)->where('status', 'open')->latest()->first();

        if (!$last_open_box) {
            $last_open_box = Box::create(['of_id' => $of_id]);
            // return $box;
        }

        // Get caliber quantity BOX
        // $caliber_quantity = Caliber::whereHas('ofs', function ($q) use ($of_id) {
        //     $q->where('id', $of_id);
        // })->first()->box_quantity;

        // Count products boxed
        $sn_in_box = SerialNumber::where('of_id', $of_id)->where('box_id', $last_open_box->id)->count();
        // dd();

        // return "update sn table";
        if ($sn_in_box  < $box_quantity) {
            // update box_id in serial_number table of product
            SerialNumber::find($sn_id)->update(['box_id' => $last_open_box->id]);

            $sn_in_box = SerialNumber::where('of_id', $of_id)->where('box_id', $last_open_box->id)->count();
        }

        // return "update status";
        if ($sn_in_box == $box_quantity) {
            Box::find($last_open_box->id)->update(['status' => "filled"]);
        }


        // Prepare response
        $response["info"] = $this->getProductInformation($of_id);
        $response["list"] = SerialNumber::whereOfId($of_id)->whereNotNull("box_id")->get(["serial_number", "created_at"]);
        return $response;
    }

    public function getProductInformation($of_id)
    {
        $product_info = SerialNumber::join('ofs', 'serial_numbers.of_id', '=', 'ofs.id')
            ->join('calibers', 'ofs.caliber_id', '=', 'calibers.id')
            ->join('products', 'calibers.product_id', '=', 'products.id')
            ->join('boxes', 'serial_numbers.box_id', '=', 'boxes.id')
            ->select(
                'of_number',
                'ofs.status',
                'ofs.created_at',
                'boxes.status as box_status',
                'calibers.box_quantity',
                'caliber_name',
                'serial_number',
                'product_name',
                'ofs.quantity as quantity',
                DB::raw("SUBSTRING_INDEX(boxes.box_qr, '-', -1) as box_number"),
                DB::raw("(select FLOOR(quantity/box_quantity)) as of_boxes")
                // DB::raw("COUNT(DISTINCT  box_id) as boxes_packaged"),
                // DB::raw("COUNT(serial_numbers.id) as products_packaged"),
            )->where('serial_numbers.of_id', '=', $of_id)
            ->orderBy("serial_numbers.updated_at", "DESC")
            ->first();
        // $product_info->of_boxes = floor($product_info->of_boxes);
        return $product_info;
    }

    // public function boxesRested($of_id)
    // {
    //     return Of::join('calibers', 'ofs.id', '=', 'calibers.id')->select(DB::raw("quantity / box_quantity"))->get();
    // }

    // public function boxingAction(int $of_id, String $sn_id)
    // {
    //     // Get Last box opened
    //     $last_open_box = Box::where('of_id', $of_id)->where('status', 'open')->latest()->first();

    //     if (!$last_open_box) {
    //         $last_open_box = Box::create(['of_id' => $of_id]);
    //         // return $box;
    //     }

    //     // Get caliber quantity BOX
    //     $caliber_quantity = Caliber::whereHas('ofs', function ($q) use ($of_id) {
    //         $q->where('id', $of_id);
    //     })->first()->box_quantity;

    //     // Count products boxed
    //     $sn_in_box = SerialNumber::where('of_id', $of_id)->where('box_id', $last_open_box->id)->count();


    //     // return "update sn table";
    //     if ($sn_in_box  < $caliber_quantity) {
    //         // update box_id in serial_number table of product
    //         SerialNumber::find($sn_id)->update(['box_id' => $last_open_box->id]);

    //         $sn_in_box = SerialNumber::where('of_id', $of_id)->where('box_id', $last_open_box->id)->count();
    //         //Send response with
    //         // return $this->sendResponse($response);
    //         $response = SerialNumber::join('ofs', 'serial_numbers.of_id', 'ofs.id')
    //             ->join('calibers', 'ofs.caliber_id', 'calibers.id')
    //             ->join('boxes', 'serial_numbers.box_id', 'boxes.id')
    //             ->where('serial_numbers.of_id', $of_id)
    //             // ->where('serial_numbers.of_id', $of_id)
    //             // ->where('serial_numbers.box_id', $last_open_box->id)
    //             ->first(
    //                 ["ofs.of_number", "ofs.status as of_status", "ofs.created_at as of_creation_date", "boxes.box_qr", "boxes.status as box_status", "calibers.box_quantity", "calibers.caliber_name", "serial_numbers.serial_number"]
    //             );
    //     }

    //     // return "update status";
    //     if ($sn_in_box == $caliber_quantity) {
    //         Box::find($last_open_box->id)->update(['status' => "filled"]);
    //         $last_filled_box = Box::where('of_id', $of_id)->where('status', 'filled')->latest()->first();

    //         $response = SerialNumber::join('ofs', 'serial_numbers.of_id', 'ofs.id')
    //             ->join('calibers', 'ofs.caliber_id', 'calibers.id')
    //             ->join('boxes', 'serial_numbers.box_id', 'boxes.id')
    //             ->where('serial_numbers.of_id', $of_id)->where('serial_numbers.box_id', $last_filled_box->id)->first(
    //                 ["ofs.of_number", "ofs.status as of_status", "ofs.created_at as of_creation_date", "boxes.box_qr", "boxes.status as box_status", "calibers.box_quantity", "calibers.caliber_name", "serial_numbers.serial_number"]
    //             );
    //         // return 'filled';
    //     }
    //     return $response;
    // }

    //TODO::Change id to code valid ;

    /**
     * Count all operation (simple) posts
     *
     * @return Int
     */
    public function countOperatorPosts()
    {
        return Post::where('posts_type_id', 2)->count();
    }

    /**
     * Get all packaging posts type
     *
     * @return collection
     */
    public function getPackagingPostsIds()
    {
        return Post::where('posts_type_id', 3)->get(["id"]);
    }

    /**
     * get all movement of qr product
     *
     * @param String $qr
     * @return collection
     */
    public function productSteps(String $qr)
    {
        return Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->where('qr', $qr)
            ->count();
    }

    public function closeOf($id)
    {
        $of = Of::findOrFail($id)->first();
        $sn = SerialNumber::where('of_id', $id)->count();
        if ($of->quantity === $sn) {
            $of->update(["status" => "closed"]);
            // return $of;
            //Send response with msg
            return $this->sendResponse("Congratulation, OF clotured");
        }
        return;
    }
}