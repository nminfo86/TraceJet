<?php

namespace App\Http\Controllers\Api\v1;


use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Requests\RoleRequest;
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
        //dd($request->toArray());
        $role = Role::create(['name' => $request->name]);

        // affect permissions to the role
        $role->givePermissionTo($request->permissions);

        return new RoleResource($role);
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
        return $this->sendResponse($this->create_success_msg, $role);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
