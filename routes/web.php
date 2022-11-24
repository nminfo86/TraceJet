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

Route::get('/welcome', function () {
    return view('welcome');
})->middleware('auth');

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
