<?php

use App\Models\Of;
use App\Models\Post;
use App\Models\PostsType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\{RoleController, UserController, CaliberController, ProductController, SectionController, AccessTokensController, OfController, SerialNumberController, PostsTypeController, PostController, MovementController, BoxController};


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/access_token', [AccessTokensController::class, 'login'])->middleware('guest:sanctum');
Route::post('register', [AccessTokensController::class, 'register']);


Route::group(
    ['middleware' => ['auth:sanctum']],

    function () {

        Route::get('user', function (Request $request) {
            $guards = array_keys(config('auth.guards'));
            foreach ($guards as $guard) {
                if (auth()->guard($guard)->check()) {
                    return $guard;
                }
            }
        });

        /* -------------------------------------------------------------------------- */
        /*                       Begin Resource controller                            */
        /* -------------------------------------------------------------------------- */
        Route::apiResources([
            'users' => UserController::class,
            'sections' => SectionController::class,
            'roles' => RoleController::class,
            'products' => ProductController::class,
            'calibers' => CaliberController::class,
            'ofs' => OfController::class,
            'serial_numbers' => SerialNumberController::class,
            'posts_types' => PostsTypeController::class,
            'posts' => PostController::class,
            'movements' => MovementController::class,
            'boxes' => BoxController::class,
        ]);
        /* ------------------------- End Resource controller ------------------------ */


        // route::get('ofs_list', function () {
        //     // return Of::pluck('of_number', 'id');
        //     return Of::pluck('of_number', 'id');
        // });
        route::get('of_quantity/{id}', function ($id) {
            return Of::latest()->findOrFail($id, ['quantity', 'of_code']);
        });




        route::get('check_qr', [SerialNumberController::class, 'checkQr']);
        /* -------------------------------------------------------------------------- */
        /*                              Groupe controller                             */
        /* -------------------------------------------------------------------------- */
        Route::controller(AccessTokensController::class)->group(function () {
            Route::delete('auth/logout', 'logout');
        });
        /* -------------------------- End groupe controller ------------------------- */





        // Route::get(
        //     'getmacshellexec',
        //     function () {
        //         // $shellexec = shell_exec('getmac');
        //         // dd(gethostname());
        //     }
        // );

        // Route::get(
        //     'getmacexec',
        //     function () {
        //         $shellexec = exec('getmac');
        //         dd($shellexec);
        //     }
        // );






        // Route::controller(RegimentController::class)->group(function () {
        //     Route::post('add_students_to_regiment', 'addStudents');
        //     Route::delete('del_students_from_regiment', 'deleteStudents');
        // });

    }
);