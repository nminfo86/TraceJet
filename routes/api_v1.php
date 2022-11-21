<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AccessTokensController;

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
// Route::delete('auth/access_token/{token?}', [AccessTokensController::class, 'destroy'])->middleware('auth:sanctum');




Route::post('auth/access_token', [AccessTokensController::class, 'login'])->middleware('guest:sanctum');


Route::group(
    ['middleware' => ['auth:sanctum']],

    function () {

        Route::get('user', function (Request $request) {
            return $request->user();
        });

        /* -------------------------------------------------------------------------- */
        /*                       Begin Resource controller                            */
        /* -------------------------------------------------------------------------- */
        Route::resources([
            'users' => UserController::class,
        ]);
        /* ------------------------- End Resource controller ------------------------ */





        /* -------------------------------------------------------------------------- */
        /*                              Groupe controller                             */
        /* -------------------------------------------------------------------------- */
        Route::controller(AccessTokensController::class)->group(function () {
            Route::delete('auth/logout', 'logout');
        });
        /* -------------------------- End groupe controller ------------------------- */















        // Route::controller(RegimentController::class)->group(function () {
        //     Route::post('add_students_to_regiment', 'addStudents');
        //     Route::delete('del_students_from_regiment', 'deleteStudents');
        // });

    }
);