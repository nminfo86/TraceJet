<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;

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
Route::get('/', function () {
    return view('pages.login');
})->name('login');
/****************************** ***********************/


/*************************route to authenticate ******************/
Route::post('authLogin', [WebAuthController::class, 'webLogin']);
/************************** end ************************************/

// /*************************route to logout ******************/
// Route::get('logout', [WebAuthController::class, 'webLogout']);
// /************************** end ************************************/

Route::group(
    ['middleware' => ['auth:sanctum'/*, 'check_ip_client'*/]],

    function () {
        Route::get('/dashboard', function () {
            return view('welcome');
        });
        Route::get('/logout', [WebAuthController::class, 'webLogout']);

        Route::get('/users', function () {
            return view('pages.users');
        })->name("users");

        Route::get('calibers', function () {
            return view('pages.calibers');
        });
        Route::get('/products', function () {
            return view('pages.products');
        });
        Route::get('ofs', function () {
            return view('pages.ofs');
        });
        Route::get('roles', function () {
            return view('pages.roles');
        });
        Route::get('serial_numbers', function () {
            return view('pages.serial_numbers');
        });
    }
);