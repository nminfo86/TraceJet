<?php

use App\Models\Of;
use App\Models\Post;
use App\Enums\ColorEnum;
use App\Models\Movement;
use App\Enums\OfStatusEnum;
use App\Models\SerialNumber;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\OperatorController;
use App\Http\Controllers\api\v1\PackagingController;
use App\Http\Controllers\Api\v1\{RoleController, UserController, CaliberController, ProductController, SectionController, AccessTokensController, PluckController, OfController, SerialNumberController, PostsTypeController, PostController, MovementController, BoxController, SerialNumbersPartController,DashboardController};
use Illuminate\Http\Client\Request;

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

        Route::controller(PluckController::class)->group(function () {
            Route::get('pluck/{model_name}', 'pluckData');
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

        route::get("test", function () {
            $of = Of::findOrFail(1)->first();
            return $sn = SerialNumber::whereOfId(1)->whereNotNull("box_id")->count();
            if ($of->quantity === $sn) {
                $of->update(["status" => "closed"]);
                // return $of;
                //Send response with msg
                return $this->sendResponse("Congratulation, OF clotured");
            }
            return;
        });



        // Route::controller(RegimentController::class)->group(function () {
        //     Route::post('add_students_to_regiment', 'addStudents');
        //     Route::delete('del_students_from_regiment', 'deleteStudents');
        // });

        route::get("t", function (Request $request) {

            // Retrieve OFs
            $ofs = Of::inSection(2)->where("id", 1)->get(['id', 'of_name']);

            // Calculate FPY for each post
            $fpy = Movement::where(function ($query) {
                // Filter out duplicate rows based on the minimum id
                $query->whereRaw('movements.id = (SELECT MIN(id) FROM movements AS m WHERE m.movement_post_id = movements.movement_post_id AND m.serial_number_id = movements.serial_number_id)');
            })
                ->join('posts', 'movements.movement_post_id', '=', 'posts.id')
                ->join('serial_numbers', 'movements.serial_number_id', '=', 'serial_numbers.id')
                ->select('posts.post_name')
                ->selectRaw('COUNT(IF(movements.result = "OK", 1, NULL)) AS count_ok')
                ->selectRaw('COUNT(IF(movements.result = "NOK", 1, NULL)) AS count_nok')
                ->selectRaw('CAST((COUNT(CASE WHEN movements.result = "OK" THEN 1 END) / COUNT(*)) * 100 AS UNSIGNED) AS FPY')

                ->groupBy('movements.movement_post_id')
                ->get();

            // Calculate total FPY for the chain
            $total_fpy = $fpy->reduce(fn ($carry, $item) => $carry * ($item->FPY / 100), 1) * 100;

            // Return the results
            return compact("ofs", "fpy", "total_fpy");
        });
    }
);
