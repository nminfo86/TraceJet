<?php

use App\Models\Of;
use App\Models\Post;
use App\Enums\ColorEnum;
use App\Models\Movement;
use App\Enums\OfStatusEnum;
use App\Models\SerialNumber;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\SettingController;
use App\Http\Controllers\api\v1\OperatorController;
use App\Http\Controllers\api\v1\PackagingController;
use App\Http\Controllers\Api\v1\{RoleController, UserController, CaliberController, ProductController, SectionController, AccessTokensController, PluckController, OfController, SerialNumberController, PostsTypeController, PostController, MovementController, BoxController, SerialNumbersPartController, DashboardController};

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
    ['middleware' => ['auth:sanctum', 'localLang']],

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
            'operators' => OperatorController::class,
            'movements' => MovementController::class,
            'packaging' => PackagingController::class,
            'boxes' => BoxController::class,
            'settings' => SettingController::class,
            // 'parts' => PartController::class,
            // 'sn_parts' => SerialNumbersPartController::class,
            // 'repairs' => RepairController::class,
        ]);
        /* ------------------------- End Resource controller ------------------------ */

        /* -------------------------------------------------------------------------- */
        /*                              Groupe controller                             */
        /* -------------------------------------------------------------------------- */
        Route::controller(AccessTokensController::class)->group(function () {
            Route::delete('auth/logout', 'logout');
        });

        // Route::controller(PluckController::class)->group(function () {
        //     Route::get('pluck/{model_name}', 'pluckData');
        // });

        Route::group(['prefix' => 'pluck'], function () {
            Route::get('{model_name}', [PluckController::class, 'pluckData']); // Use the middleware alias you registered
        });


        /* -------------------------- End groupe controller ------------------------- */

        /* -------------------------------------------------------------------------- */
        /*                                Custom route                                */
        /* -------------------------------------------------------------------------- */
        // route::get('current_post/{ip}', [PostController::class, 'getCurrentPost']);


        /* ---------------------------- End custom route ---------------------------- */


        route::get('of_quantity/{id}', function ($id) {
            return Of::latest()->findOrFail($id, ['quantity', 'of_code']);
        });



        // route::get('check_qr', [SerialNumberController::class, 'validProduct']);
        route::post('serial_numbers/qr_print', [SerialNumberController::class, 'printQrCode']);
        route::get('serial_numbers/qr_life/{id}', [SerialNumberController::class, 'productLife']);
        // Route::controller(RegimentController::class)->group(function () {
        //     Route::post('add_students_to_regiment', 'addStudents');
        //     Route::delete('del_students_from_regiment', 'deleteStudents');
        // });


        route::get('of_details/{of_id}', [OfController::class, 'getOfDetails']);
        route::get('of_statistics/{of_id}', [OfController::class, 'ofStatistics']);



        route::get('dashboard', [DashboardController::class, 'index']);
        // route::get('ofsBySection/{id}', [DashboardController::class, 'ofsListBySection']);



        // route::get('packaging/count_boxes_products', [PackagingController::class, 'packagedBoxProducts']);
        /* -------------------------------------------------------------------------- */
        /*                                    Enums                                   */
        /* -------------------------------------------------------------------------- */
        route::get('of_status', function () {
            return OfStatusEnum::values();
        });

        route::get('colors', function () {
            return ColorEnum::values();
        });



        /* -------------------------------------------------------------------------- */
        /*                                    TEST                                    */
        /* -------------------------------------------------------------------------- */
        #reparation post get part of sn

        Route::controller(SerialNumber::class)->group(function () {
            Route::get('getSnParts', function () {
                return SerialNumber::with("parts")->get();
            });

            route::get('store/', function () {

                $sn = SerialNumber::find(2);
                $sn->parts()->attach([$sn->id => [
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
    }
);
