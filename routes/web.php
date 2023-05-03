<?php

use Carbon\Carbon;
use App\Models\SerialNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Models\Movement;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/***************default route *************************/
Route::prefix(LaravelLocalization::setLocale())->get('/', function () {
    if (Auth::check())
        return view('welcome');
    else
        return view('pages.login');
})->name('login');
/****************************** ***********************/


/*************************route to authenticate ******************/
Route::post('authLogin', [WebAuthController::class, 'webLogin']);
/************************** end ************************************/

// /*************************route to logout ******************/
// Route::get('logout', [WebAuthController::class, 'webLogout']);
// /************************** end ************************************/

// Route::group(['middleware' => ['auth:sanctum', /*'check_ip_client'*/]],

//     function () {
Route::group(
    ['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {
        Route::get('/dashboard', function () {
            return view('welcome');
        });
        Route::get('/logout', [WebAuthController::class, 'webLogout']);

        Route::get('/users', function () {
            return view('pages.users');
        })->name("users")->middleware('permission:user-list');

        Route::get('calibers', function () {
            return view('pages.calibers');
        })->middleware('permission:caliber-list');
        Route::get('/products', function () {
            return view('pages.products');
        })->middleware('permission:product-list');
        Route::get('ofs', function () {
            return view('pages.ofs');
        })->middleware('permission:of-list');
        Route::get('roles', function () {
            return view('pages.roles');
        })->middleware('permission:role-list');
        Route::get('hosts', function () {
            return view('pages.hosts');
        })->middleware('permission:host-list');




        Route::get('serial_numbers', function () {
            // dd(Carbon::now());
            return view('pages.serial_numbers');
        });




        Route::get('packaging', function () {
            return view('pages.packaging');
        });
        Route::get('operator', function () {
            return view('pages.operator');
        });


        route::get("ss", function () {

            // return SerialNumber::with(["movements" => function ($q) {
            //     $q->whereMovementPostId(3);
            // }])->where("of_id", 1)->get();
            return Movement::join("serial_numbers", "movements.serial_number_id", "serial_numbers.id")
                ->whereMovementPostId(3)->get(["serial_numbers.serial_number", "result", "movements.created_at"]);



            // return Movement::select(["id", "result"])->whereMovementPostId(3)->with(['serialNumber' => function ($query) {
            //     $query->select('id', 'serial_number');
            // }])->get();
            return Movement::with(['serialNumber' => function ($query) {
                return $query->select('id', 'serial_number', 'created_at');
            }])->whereMovementPostId(3)->get();

            // return Movement::with("serialNumber")->get();
            // dd(Carbon::now());
            // return $sn = SerialNumber::with(["movements" => function ($q) {
            //     $q->whereMovementPostId(3);
            // }])->find(1);
        });
        route::get("time", function () {
            // set timezone
            // Carbon::setTimezone('Africa/Algiers');

            // get current time
            $now = Carbon::now();
            return $now;
            // return response with JSON
            return response()->json(['date' => $now]);
        });
    }
);
