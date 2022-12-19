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

Route::group(
    ['middleware' => ['auth:sanctum']],

    function () {
        Route::get('/dashboard', function () {
            return view('welcome');
        });
        Route::get('/logout', [WebAuthController::class, 'webLogout'] );
        Route::get('/users', function () {
            return view('pages.admin.users');
        });
    });

/*Route::get('/', function () {
    return view('welcome');
})->middleware("auth");*/
// Route::group(
//     ['middleware' => ['auth:sanctum']],

//     function () {

//         Route::get('/', function () {
//             return view('welcome');
//     });
// });
// Route::fallback(function () {
//     return view('pages.login');
// });
