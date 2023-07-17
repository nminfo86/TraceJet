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


    // public function pluckData($model_name, Request $request)
    // {

    //     // dd($request->filter);
    //     $data = match (true) {
    //         $model_name == "sections" => Section::filterBySection()->pluck('section_name', 'id'),
    //         // $model_name == "sections" => Section::pluck('section_name', 'id'),
    //         $model_name == "permissions" => Permission::pluck('name', 'id'),
    //         $model_name == "roles" => Role::pluck('name', 'id'),
    //         $model_name == "posts_types" => PostsType::pluck('posts_type', 'id'),

    //         // Multiple pluck
    //         $model_name == "products" && $request->filter == null => Product::filterBySection()->pluck('product_name', 'id'),
    //         $model_name == "products"  && $request->filter == "hasCal" => Product::filterBySection()->has("calibers")->pluck('product_name', 'id'),

    //         $model_name == "posts" && collect($request->all())->keys()[0] === "section_id" => Post::whereSectionId($request->section_id)->pluck('post_name', 'id'),


    //         /* -------------------------------------------------------------------------- */
    //         /*                                     OF                                     */
    //         /* -------------------------------------------------------------------------- */
    //         $model_name == "ofs" && $request->filter == "status" => Of::filterBySection()->where("status", "new")->orWhere("status", "inProd")->pluck('of_name', 'id'),

    //         $model_name == "ofs" => Of::pluck('of_name', 'id'),



    //         /* -------------------------------------------------------------------------- */
    //         /*                                   Caliber                                  */
    //         /* -------------------------------------------------------------------------- */

    //         $model_name == "calibers" && $request->filter == null => Caliber::pluck('caliber_name', 'id'),
    //         $model_name == "calibers" && $request->filter !== null => Caliber::whereProductId($request->filter)->pluck('caliber_name', 'id'),


    //         default => 'Unknown error: ' . $model_name
    //     };
    //     if ($model_name == "permissions") {

    //         $translatedPermissions = [];
    //         // dd($data);
    //         foreach ($data as $k => $permission) {

    //             $explode = explode("-", $permission);
    //             $page = $explode[0];
    //             if (!array_key_exists($permission, $translatedPermissions)) {
    //                 // Add the 'translatedPermissions' translatedPermissions with a default value to the array
    //                 $translatedPermissions[trans($page)][] = [$k, trans($permission)];
    //             }
    //         }
    //         return $this->sendResponse(data: $translatedPermissions);
    //     }
    //     //Send response with data
    //     return !is_string($data) ? $this->sendResponse(data: $data) : $this->sendResponse($data, status: false);
    // }

    public function pluckData($model_name, Request $request)
    {
        // Define an empty array to hold the resulting data
        $data = [];

        // Use a switch statement for better readability
        switch ($model_name) {
            case "sections":
                // Retrieve sections filtered by section
                $data = Section::filterBySection()->pluck('section_name', 'id');
                break;
            case "permissions":
                // Retrieve all permissions and format the data
                $permissions = Permission::pluck('name', 'id');
                $data = $this->formatPermissions($permissions);
                break;
            case "roles":
                // Retrieve roles
                $data = Role::pluck('name', 'id');
                break;
            case "posts_types":
                // Retrieve post types
                $data = PostsType::pluck('posts_type', 'id');
                break;
            case "products":
                if ($request->filter == "hasCal") {
                    // Retrieve products with calibers
                    $data = Product::filterBySection()->has("calibers")->pluck('product_name', 'id');
                } else {
                    // Retrieve all products filtered by section
                    $data = Product::filterBySection()->pluck('product_name', 'id');
                }
                break;
            case "posts":
                if ($request->has("section_id")) {
                    // Retrieve posts based on section_id
                    $data = Post::whereSectionId($request->section_id)->pluck('post_name', 'id');
                }
                break;
            case "ofs":
                if ($request->filter == "status") {
                    // Retrieve ofs with specific status and filtered by section
                    $data = Of::filterBySection()->whereIn("status", ["new", "inProd"])->pluck('of_name', 'id');
                }
                //  else if ($request->has("section_id")) {
                //     $data = Of::InSection($request->section_id)->pluck('of_name', 'id');
                // }
                else if ($request->has("caliber_id") && $request->has('has')) {
                    $data = Of::has($request->has)->whereCaliberId($request->caliber_id)->pluck('of_name', 'id');
                } else {
                    // Retrieve all ofs filtered by section
                    $data = Of::pluck('of_name', 'id');
                }
                break;
            case "calibers":
                if ($request->filter !== null) {
                    // Retrieve calibers filtered by product_id
                    $data = Caliber::whereProductId($request->filter)->pluck('caliber_name', 'id');
                } else if ($request->has("section_id") && $request->has('ofs')) {
                    $data = Caliber::InSection($request->section_id)->has($request->has)->pluck('caliber_name', 'id');
                } else {
                    // Retrieve all calibers
                    $data = Caliber::pluck('caliber_name', 'id');
                }
                break;
            default:
                // Unknown model name
                return $this->sendResponse('Unknown error: ' . $model_name, status: false);
        }

        if ($model_name == "permissions") {
            // Format translated permissions
            $translatedPermissions = $this->formatTranslatedPermissions($data);
            return $this->sendResponse(data: $translatedPermissions);
        }

        // Send response with data
        return $this->sendResponse(data: $data);
    }

    /**
     * Format the permissions data with translation keys
     *
     * @param  array  $permissions
     * @return array
     */
    private function formatPermissions($permissions)
    {
        $translatedPermissions = [];

        foreach ($permissions as $k => $permission) {
            $explode = explode("-", $permission);
            $page = $explode[0];

            if (!array_key_exists($permission, $translatedPermissions)) {
                // Add the translated permission with a default value to the array
                $translatedPermissions[trans($page)][] = [$k, trans($permission)];
            }
        }

        return $translatedPermissions;
    }

    /**
     * Format the translated permissions data
     *
     * @param  array  $permissions
     * @return array
     */
    private function formatTranslatedPermissions($permissions)
    {
        $translatedPermissions = [];

        foreach ($permissions as $page => $permissionList) {
            $translatedPermissions[trans($page)] = $permissionList;
        }

        return $translatedPermissions;
    }
}
