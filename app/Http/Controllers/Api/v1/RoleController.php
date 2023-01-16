<?php

namespace App\Http\Controllers\Api\v1;


use Exception;
use App\Exceptions\ExceptionTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use ResponseTrait;

    function __construct()
    {
        // $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get(["id", "name"]);
        // $roles = Role::with('permissions:id,name')->select(['roles.id', 'roles.name'])->get();

        //Send response with data
        return $this->sendResponse(data: $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            DB::beginTransaction();

            $role = Role::create(['name' => $request->name]);

            // affect permissions to the role
            $role->syncPermissions($request->input('permissions'));

            DB::commit();

            //Send response with data
            return $this->sendResponse($this->create_success_msg, data: new RoleResource($role));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->apiException($request, $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        // //Send response with data
        return $this->sendResponse(data: new RoleResource($role));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Role $role, Request $request)
    {
        try {
            DB::beginTransaction();

            $role->update(["name" => $request->name]);

            // affect permissions to the role
            $role->syncPermissions($request->permissions);

            DB::commit();

            //Send response with data
            return $this->sendResponse($this->update_success_msg, data: new RoleResource($role));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->apiException($request, $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        //Send response with success
        return $this->sendResponse($this->delete_success_msg);
    }
}