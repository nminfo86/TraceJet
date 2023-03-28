<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Movement;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    //

    public function getProduct(Request $request)
    {
        $post = Post::whereMac("mac4")->first();
        $last_movement = Movement::join('serial_numbers', 'movements.serial_number_id', 'serial_numbers.id')
            ->join('ofs', 'serial_numbers.of_id', 'ofs.id')
            ->join('calibers', 'ofs.caliber_id', 'calibers.id')
            ->where('serial_numbers.qr',  $request->qr)
            //    todo::fixme
            // ->where('ofs.status', "inProd")
            ->latest("movements.created_at")->first(['movement_post_id', 'serial_numbers.of_id', 'qr', 'serial_number_id', 'result', 'caliber_name', 'box_quantity', 'serial_numbers.serial_number']);

        if ($last_movement->movement_post_id == $post->previous_post_id) {
            return $last_movement;
        }
        return $this->sendResponse('Product does not belong to the current OF', status: false);
    }
}
