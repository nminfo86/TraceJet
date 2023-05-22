<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Models\{Of, Caliber, Host, PostsType, Product, Section};

class PluckController extends Controller
{
    use ResponseTrait;
    // TODO::change to invoke Controller

    /* public function pluckData($model_name)
    {
        $data = match ($model_name) {
            "products" => Product::pluck('product_name', 'id'),
            "sections" => Section::pluck('section_name', 'id'),
            "permissions" => Permission::pluck('name', 'id'),
            "roles" => Role::pluck('name', 'id'),
            // FIXME::Valid later
            "ofs" => Of::whereStatus("inProd")->orWhere("status", "new")->get(['of_code', 'id', 'status']),
            "calibers" => Caliber::pluck('caliber_name', 'id'),
            default => 'Unknown error: ' . $model_name
        };
        //Send response with data
        return !is_string($data) ? $this->sendResponse(data: $data) : $this->sendResponse($data, status: false);
    }*/


    public function pluckData($model_name, Request $request)
    {

        // dd($request->filter);
        $data = match (true) {
            $model_name == "sections" => Section::filterBySection()->pluck('section_name', 'id'),
            // $model_name == "sections" => Section::pluck('section_name', 'id'),
            $model_name == "permissions" => Permission::pluck('name', 'id'),
            $model_name == "roles" => Role::pluck('name', 'id'),
            $model_name == "posts_types" => PostsType::pluck('posts_type', 'id'),

            // Multiple pluck
            $model_name == "products" && $request->filter == null => Product::filterBySection()->pluck('product_name', 'id'),
            $model_name == "products"  && $request->filter == "hasCal" => Product::filterBySection()->has("calibers")->pluck('product_name', 'id'),

            $model_name == "posts" && collect($request->all())->keys()[0] === "section_id" => Post::whereSectionId($request->section_id)->pluck('post_name', 'id'),

            $model_name == "ofs" && $request->filter == "status" => Of::filterBySection()->whereStatus("inProd")->orWhere("status", "new")->pluck('of_name', 'id'),
            $model_name == "ofs" => Of::pluck('of_name', 'id'),

            $model_name == "calibers" && $request->filter == null => Caliber::pluck('caliber_name', 'id'),
            $model_name == "calibers" && $request->filter !== null => Caliber::whereProductId($request->filter)->pluck('caliber_name', 'id'),


            default => 'Unknown error: ' . $model_name
        };
        if ($model_name == "permissions") {

            $translatedPermissions = [];
            // dd($data);
            foreach ($data as $k => $permission) {

                $explode = explode("-", $permission);
                $page = $explode[0];
                if (!array_key_exists($permission, $translatedPermissions)) {
                    // Add the 'translatedPermissions' translatedPermissions with a default value to the array
                    $translatedPermissions[trans($page)][] = [$k, trans($permission)];
                }
            }
            return $this->sendResponse(data: $translatedPermissions);
        }
        //Send response with data
        return !is_string($data) ? $this->sendResponse(data: $data) : $this->sendResponse($data, status: false);
    }
}
