<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\ExceptionTrait;

class UserController extends Controller
{
    use ExceptionTrait;

    function __construct()
    {
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::with('section')->get();
        $users=User::join('sections','users.section_id','sections.id')->get(['username','section_name','roles_name','users.id']);
        //Send response with success
        // return array('data'=>$users);
        return $this->sendResponse(data:$users);

        // return UserCollection::make($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            // register user
            $user = User::create([
                'section_id'          => $request->section_id,
                'username'          => $request->username,
                'name'          => $request->name,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'roles_name' =>  [$request->roles_name],
            ]);

            // assign role
            $user->assignRole($request->input('roles_name'));
            DB::commit();

            // send response
            // return new UserResource($user);
            return $this->sendResponse($this->create_success_msg, $user);
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
    public function show(User $user)
    {
        //Send response with success
        return $this->sendResponse(data: $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        $user->assignRole($request->input('roles_name'));

        //Send response with success
        return $this->sendResponse($this->update_success_msg, $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        //Send response with success
        return $this->sendResponse($this->delete_success_msg);
    }
}
