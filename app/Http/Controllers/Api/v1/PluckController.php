<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Models\{Of, Caliber, Host, PostsType, Printer, Product, Section};

class PluckController extends Controller
{
    use ResponseTrait;




    public function pluckData($model_name, Request $request)
    {
        // Define an empty array to hold the resulting data
        $data = [];
        $permission[0] =  Str::substr($model_name, 0, -1) . '-create';
        $permission[1] =  Str::substr($model_name, 0, -1) . '-edit';
        // dd($permission);
        // Use a switch statement for better readability
        switch ($model_name) {
            case "sections":
                if ($request->has('has')) {

                    // Retrieve products with calibers
                    $data = Section::filterBySection()->has($request->has)->pluck('section_name', 'id');
                } else
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
                if ($request->has("filter")) {
                    $data = $request->filter == "prod" ? Of::filterBySection()->where("status", "inProd")->pluck('of_name', 'id') : Of::filterBySection()->whereIn("status", ["new", "inProd"])->pluck('of_name', 'id');
                } elseif ($request->has("caliber_id") && $request->has('has')) {
                    $data = Of::filterBySection()->has($request->has)->whereCaliberId($request->caliber_id)->pluck('of_name', 'id');
                } else {
                    // Retrieve all ofs filtered by section
                    $data = Of::pluck('of_name', 'id');
                }
                break;

            case "calibers":
                // if ($this->checkPermission($permission) !== true) {
                //                        return $this->checkPermission($permission);
                // }
                if ($request->filter !== null) {
                    // Retrieve calibers filtered by product_id
                    $data = Caliber::whereProductId($request->filter)->pluck('caliber_name', 'id');
                } else if ($request->has("section_id") && $request->has('has')) {
                    $data = Caliber::InSection($request->section_id)->has($request->has)->pluck('caliber_name', 'id');
                } else {
                    // Retrieve all calibers
                    $data = Caliber::pluck('caliber_name', 'id');
                }
                break;

            case "printers":

                // Retrieve all ofs filtered by section
                $data = Printer::pluck('name', 'id');

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


    // private function checkPermission($permission)
    // {
    //     // dd($permission[0]);
    //     // if (!auth()->user()->can($permission[0]) && !auth()->user()->can($permission[1])) {
    //     //     // return response('User does not have the right permissions.');
    //     //     //Send response with success
    //     //     $msg = $this->getResponseMessage("permission");
    //     //     return $this->sendResponse($msg, status: false);
    //     // } else
    //     return true;
    // }
}
