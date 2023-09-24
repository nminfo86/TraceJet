<?php

namespace App\Services;

use App\Models\Of;
use App\Models\Post;
use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class ProductService
{
    use ResponseTrait;

    /**
     * Check the product steps to ensure that it's valid for the current operation
     *
     * @param  Request  $request  The current request object
     * @param  Movement $last_movement  The last movement record of the product
     * @return Response The response message with the status
     */

    public function checkProductSteps($request,  $last_movement)
    {

        // Check if the product exists in the current OF
        // if (!$last_movement) {
        //     // $msg = $this->getResponseMessage('not_found', ['attribute' => 'product']);
        //     $msg = __("exception-errors.resource_not_found");
        //     return $this->sendResponse($msg, status: false);
        // }

        // Verify that the product has not already passed through the current post
        if ($last_movement->movement_post_id == $request->host_id) {
            // $msg = $this->getResponseMessage('exists', ['attribute' => 'product']);
            $msg = __("exception-errors.post_exists");
            return $this->sendResponse($msg, status: false);
        }

        // Get the name of last movement post
        $post_name = Post::findOrFail($last_movement->movement_post_id)->post_name;

        // Check if the product has moved from the correct previous post
        if ($last_movement->movement_post_id != $request->previous_post_id) {
            // dd($request);
            // $msg = $this->getResponseMessage('incorrect_previous_post', ['expected_host' => $post_name]);
            $msg = __("exception-errors.incorrect_previous_post", ['expected_host' => $post_name]);
            return $this->sendResponse($msg, status: false);
        }

        // Check if the result of the last movement is NOK
        if ($last_movement->result == 'NOK') {
            $msg = __("exception-errors.last_movement_nok", ['post_name' => $post_name]);
            return $this->sendResponse($msg, status: false);
        }

        // Update the current post of the product
        $last_movement->current_post_id = $request->host_id;
        // $last_movement->save();

        // Send response with the updated last_movement object
        return $this->sendResponse(data: $last_movement, status: true);
    }

    public function checkOfStatus($of_id, $index = false)
    {
        // $index is index function its mean index page
        $error = false;
        $of = Of::findOrFail($of_id);

        if ($of->status->value == "closed") {
            $error = true;
            return ["error" => $error, "message" => "of_closed"];
        }
        if ($of->status->value == "posed") {
            $error = true;
            return ["error" => $error, "message" => "of_posed"];
        }
        if (!$index && $of->new_quantity === $this->countValidProducts($of->id)) {
            $error = true;
            return ["error" => $error, "message" => "of_valid"];
        }

        if (request()->posts_type !== 1 && $of->status->value == "new") {
            $error = true;
            return ["error" => $error, "message" => "of_new"];
        }
        return ["of" => $of, 'error' => $error];


        // Check with OF quantity
        // if ($of->new_quantity === $this->countValidProducts($of->id)) {
        //     $error = true;
        //     return ["error" => $error, "message" => "of_valid"];
        // }
    }


    // public function countValidProducts($of_id)
    // {
    //     return SerialNumber::whereOfId($of_id)->whereValid(1)->count();
    // }
    public function countValidProducts($of_id)
    {

        // dd(request());
        if (request()->posts_type == 1) {
            $movements = SerialNumber::whereOfId($of_id)->whereValid(1)->count();
        } else {
            $movements = Movement::distinct()
                ->join('serial_numbers', 'movements.serial_number_id', '=', 'serial_numbers.id')
                ->where('serial_numbers.of_id', $of_id)
                ->where('movement_post_id', request()->posts_type)
                ->select('movements.*')
                ->count();
        }
        return $movements;



        // for SN
        // return SerialNumber::whereOfId($of_id)->whereValid(1)->count();

        // return   $posts = Movement::whereHas('serial_number', function ($query) use ($of_id) {
        //     $query->where('of_id', $of_id);
        // })->get();
        // return  SerialNumber::with('movements'=> fn ($query) => $query->where('of_id', $of_id))->get();


        // whereOfId($of_id)->whereValid(1)->count();
    }
}
