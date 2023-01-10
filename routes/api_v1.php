<?php

use App\Models\Of;
use App\Models\Part;
use App\Models\SerialNumber;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\PartController;
use App\Http\Controllers\Api\v1\{RoleController, UserController, CaliberController, ProductController, SectionController, AccessTokensController, PluckController, OfController, SerialNumberController, PostsTypeController, PostController, MovementController, BoxController, SerialNumbersPartController};
use Illuminate\Http\Request;

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
            'parts' => PartController::class,
            'sn_parts' => SerialNumbersPartController::class,
        ]);
        /* ------------------------- End Resource controller ------------------------ */

        /* -------------------------------------------------------------------------- */
        /*                              Groupe controller                             */
        /* -------------------------------------------------------------------------- */
        Route::controller(AccessTokensController::class)->group(function () {
            Route::delete('auth/logout', 'logout');
        });

        Route::controller(PluckController::class)->group(function () {
            Route::get('pluck/{model_name}', 'pluckData');
        });
        /* -------------------------- End groupe controller ------------------------- */


        route::get('of_quantity/{id}', function ($id) {
            return Of::latest()->findOrFail($id, ['quantity', 'of_code']);
        });
        route::get('of/{id}', function ($id) {

            return  $sn_in_box = SerialNumber::query()->get();
        });


        route::get('check_qr', [SerialNumberController::class, 'checkQr']);



        /* -------------------------------------------------------------------------- */
        /*                                    TEST                                    */
        /* -------------------------------------------------------------------------- */
        #reparation post get part of sn
        route::get('many', function () {

            return SerialNumber::with("parts")->get();
        });
        Route::controller(SerialNumber::class)->group(function () {
            Route::get('getSnParts', function () {
                return SerialNumber::with("parts")->get();
            });

            route::get('store/', function () {

                $sn = SerialNumber::find(1);
                $sn->parts()->attach([1 => [
                    'part_id' => 1,
                    "quantity" => 20
                ], [
                    'part_id' => 2,
                    "quantity" => 20
                ]]);
                return $sn;
                // return SerialNumber::with("parts")->get();
            });
        });



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