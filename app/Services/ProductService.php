<?php

namespace App\Services;

use App\Models\Post;
use App\Traits\ResponseTrait;

class ProductService
{
    use ResponseTrait;

    /**
     * checkProductSteps void
     *
     * @param  mixed $request  [mac_address,new result]
     * @param  mixed $last_movement [movement_post_id,result]
     * @return \Illuminate\Http\Response
     */

    /** checkProductSteps void */
    public function checkProductSteps($request,  $last_movement)
    {
        $msg = "";

        // Check existence of product in current OF
        if (!$last_movement) {
            $msg = $this->getResponseMessage("not_found", ["attribute" => "product"]);
            return $this->sendResponse($msg, status: false);
        }
        // Get current post information by mac_address ==>ip address for check previous post
        // $current_post = $this->getCurrentPostInformation($request->mac);
        // if (!$current_post)
        //     $msg = 'invalid post';

        // Verify that the product has passed on this post
        if ($last_movement->movement_post_id == $request->host_id) {
            $msg = $this->getResponseMessage("exists", ["attribute" => "product"]);
            // return $this->sendResponse($msg, status: false);
        }

        // Get the name of last movement post
        $post_name = Post::findOrFail($last_movement->movement_post_id)->post_name;

        // Check last movement
        if ($last_movement->movement_post_id != $request->previous_post_id)
            $msg = $this->getResponseMessage("product_place", ["attribute" => "product", "host" => $post_name]);

        // Check result of last movement
        if ($last_movement->result == 'NOK')
            $msg = "nok , $post_name";

        // return response error message
        if ($msg !== "")
            return $this->sendResponse($msg, status: false);


        $last_movement->current_post_id = $request->host_id;
        // dd($last_movement);
        return $this->sendResponse(data: $last_movement, status: true);
    }
}
