<?php

namespace App\Http\Controllers\Api\v1;


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
        $roles = Role::get();
        // return ;
        //Send response with data
        return $this->sendResponse(data: RoleResource::collection($roles));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        // DB::beginTransaction();

        // db::commit();

        // return new RoleResource($role);
        // $role->givePermissionTo(
        //     $permissions
        // );

        // dd($permissions->pluck('name'));

        // return new UserResource($role);
        // Reset cached roles and permissions

        //add a permission
        // $testPermission = 'all-permissions';
        // Permission::create(['guard_name' => 'web', 'name' => $testPermission]);

        //add a role
        // $testRole = Role::create(['guard_name' => 'web', 'name' => 'test_role']);
        //Send response with success
        // return $this->sendResponse($this->create_success_msg, $role);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        // $role = Role::findOrFail($id);

        return new RoleResource($role);
        // $role = Role::find($id, ["id", "name"]);

        // $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
        //     ->where("role_has_permissions.role_id", $id)
        //     ->get(["id", "name"]);

        // return $this->sendResponse(data: RoleResource::collection($roles));
        // //Send response with data
        // return $this->sendResponse(data: array('role' => $role, 'permissions' => $rolePermissions));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* get role by id */
        $role = Role::find($id);
        /* update role name */
        $role->name = $request->input('name');
        /* sync permission to the role */
        $role->syncPermissions($request->permissions);
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