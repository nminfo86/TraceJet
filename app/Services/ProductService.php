<?php

namespace App\Services;

use App\Models\Post;
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
        if (!$last_movement) {
            $msg = $this->getResponseMessage('not_found', ['attribute' => 'product']);
            return $this->sendResponse($msg, status: false);
        }

        // Verify that the product has not already passed through the current post
        if ($last_movement->movement_post_id == $request->host_id) {
            $msg = $this->getResponseMessage('exists', ['attribute' => 'product']);
            return $this->sendResponse($msg, status: false);
        }

        // Get the name of last movement post
        $post_name = Post::findOrFail($last_movement->movement_post_id)->post_name;

        // Check if the product has moved from the correct previous post
        if ($last_movement->movement_post_id != $request->previous_post_id) {
            $msg = $this->getResponseMessage('product_place', ['attribute' => 'product', 'host' => $post_name]);
            return $this->sendResponse($msg, status: false);
        }

        // Check if the result of the last movement is NOK
        if ($last_movement->result == 'NOK') {
            $msg = "NOK , $post_name";
            return $this->sendResponse($msg, status: false);
        }

        // Update the current post of the product
        $last_movement->current_post_id = $request->host_id;
        // $last_movement->save();

        // Send response with the updated last_movement object
        return $this->sendResponse(data: $last_movement, status: true);
    }
}
