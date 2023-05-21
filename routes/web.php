<?php

use App\Models\Of;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Caliber;
use App\Models\Product;
use App\Models\Section;
use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\Api\v1\SerialNumberController;
use App\Models\User;
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
        Route::get('sections', function () {
            return view('pages.section');
        })->middleware('permission:section-list');
        Route::get('posts', function () {
            return view('pages.posts');
        })->middleware('permission:post-list');
        Route::get('ofs', function () {
            return view('pages.ofs');
        })->middleware('permission:of-list');
        Route::get('of_statistics/{id}', function () {
            return view('pages.of_statistics');
        })->middleware('permission:of-list');
        Route::get('roles', function () {
            return view('pages.roles');
        })->middleware('permission:role-list');
        Route::get('serial_numbers', function () {
            // dd(Carbon::now());
            return view('pages.serial_numbers');
        });
        Route::get('packaging', function () {
            return view('pages.packaging');
        });
        Route::get('operators', function () {
            return view('pages.operators');
        });



        Route::get('dash', function () {

            $startDate = '2023-05-17 08:30:00';
            $endDate = '2023-05-30 08:58:00';
            $response = [];
            $section_id = 1;



            $productQuery = Product::query();
            $userQuery = User::query();
            $caliberQuery = Caliber::query();
            $postQuery = Post::query();
            $ofQuery = Of::join("calibers", "ofs.caliber_id", "calibers.id")->join("products", "calibers.product_id", "products.id");

            // Check if a product ID filter is provided
            if ($section_id == 1) {

                $productQuery->whereSectionId($section_id);
                $userQuery->whereSectionId($section_id);
                $postQuery->whereSectionId($section_id);
                $caliberQuery->ProductBySection($section_id);
                $ofQuery->where("products.section_id", $section_id);
            }

            $response["products"] = $productQuery->count();
            $response["users"] = $userQuery->count();
            $response["calibers"] = $caliberQuery->count();
            $response["posts"] = $postQuery->count();
            $response["ofs"] = $ofQuery->count();



            // Quantité fabriqué par chaque post filtrée by section_id

            $response["posts_movements"] = Post::select('id', 'post_name')
                ->with(['movements' => function ($query) use ($section_id, $startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate])
                        ->with(['posts' => function ($query) use ($section_id) {
                            $query->where('section_id', $section_id);
                        }]);
                }])
                ->withCount(['movements' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }])
                ->get()->makeHidden("movements");






            // Of Lists

            // return Of::get();





            return $response;
        });
    }
);
