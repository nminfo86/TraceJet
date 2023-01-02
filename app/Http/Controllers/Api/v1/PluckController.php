<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\{Of, Caliber, Product, Section};

class PluckController extends Controller
{
    // TODO::change to invoke Controller

    public function pluckData($model_name)
    {
        $data = match ($model_name) {
            "products" => Product::pluck('product_name', 'id'),
            "sections" => Section::pluck('section_name', 'id'),
            "permissions" => Permission::pluck('name', 'id'),
            "roles" => Role::pluck('name', 'id'),
            "ofs" => Of::pluck('of_code', 'id'),
            "calibers" => Caliber::pluck('caliber_name', 'id'),
            default => 'Unknown error: ' . $model_name
        };
        //Send response with data
        return !is_string($data) ? $this->sendResponse(data: $data) : $this->sendResponse($data, status: false);
    }
}
