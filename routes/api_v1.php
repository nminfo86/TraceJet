<?php

use App\Models\Of;
use App\Models\Box;
use App\Models\Part;
use App\Enums\OfStatusEnum;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\Api\v1\PartController;
use App\Http\Controllers\api\v1\PackagingController;
use App\Http\Controllers\Api\v1\{RoleController, UserController, CaliberController, ProductController, SectionController, AccessTokensController, PluckController, OfController, SerialNumberController, PostsTypeController, PostController, MovementController, BoxController, SerialNumbersPartController};

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
            'packaging' => PackagingController::class,
            'boxes' => BoxController::class,
            'parts' => PartController::class,
            'sn_parts' => SerialNumbersPartController::class,
            'repairs' => RepairController::class,
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

            return SerialNumber::query()->get();
        });


        // route::get('check_qr', [SerialNumberController::class, 'validProduct']);
        route::post('serial_numbers/qr_print', [SerialNumberController::class, 'printQrCode']);
        route::get('of_details/{of_id}', [OfController::class, 'getOfDetails']);



        // route::get('packaging/count_boxes_products', [PackagingController::class, 'packagedBoxProducts']);
        /* -------------------------------------------------------------------------- */
        /*                                    Enums                                   */
        /* -------------------------------------------------------------------------- */
        route::get('of_status', function () {
            // return 'jlksdjfs';
            return OfStatusEnum::values();
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
        // Select of_number,ofs.status,ofs.created_at,boxes.status as box_status,box_quantity,caliber_name,serial_number,product_name,
        // SUBSTRING_INDEX(boxes.box_qr, '-', -1) as box_number,
        // COUNT(DISTINCT  box_id) as box_emballé,
        // COUNT(serial_numbers.id) as products_packaged,
        // ofs.quantity as quantity
        // from serial_numbers
        // JOIN ofs on serial_numbers.of_id=ofs.id
        // JOIN calibers on ofs.id=calibers.id
        // JOIN products on calibers.product_id=products.id
        // JOIN boxes on serial_numbers.box_id=boxes.id
        // WHERE serial_numbers.of_id=1
        // ORDER BY boxes.box_qr DESC;
        route::get("test", function () {
            return Box::whereOfId(1)->count();

            // $boxes_packaged = SerialNumber::join("boxes", "serial_numbers.box_id", "boxes.id")->where("serial_numbers.of_id", 1)->first([
            //     DB::raw("COUNT(DISTINCT  box_id) as boxes_packaged")
            //     // DB::raw("COUNT(serial_numbers.id) as products_packaged"),
            // ])->boxes_packaged;
            // return $var2;

            // return  $box_quantity = Of::with("quantity")->find(1);




            // $info->boxes_packaged = $boxes_packaged;
            // return $info;
        });

        // -- COUNT(DISTINCT  box_id) as box_emballé,
        // -- COUNT(serial_numbers.id) as products_packaged,


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
