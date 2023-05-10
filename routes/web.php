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
            return view('pages.operator');
        });

        Route::get('test', function () {


            // Récupérer l'OF avec ses numéros de série et les informations de son calibre et du produit associé
            $of = Of::with([
                // 'serialNumbers' => fn ($q) => $q->select("id", "of_id", "qr")->where("valid", 1),
                'caliber.product.section.posts' => fn ($query) =>
                // Limiter les résultats aux posts de la section 1
                $query->where('section_id', 1)
                    ->orderByDesc("post_name")
                    ->select('id', 'post_name', 'code', 'section_id')
                    ->withCount('movements')
            ])
                ->select('id', 'of_number', 'of_name', 'status', 'new_quantity', 'caliber_id')
                ->find(1);

            $of_quantity = $of->new_quantity;
            $posts = $of->caliber->product->section->posts;
            // Calculer les pourcentages de mouvements et de stockage pour chaque post
            $posts->each(function ($post) use ($of_quantity) {
                $post->movement_percentage = $post->movements_count / $of_quantity * 100;
                $post->stayed = 100 - $post->movement_percentage;
            });

            // Retourner l'OF avec les informations des numéros de série et des posts
            // return $of;



            // Retrieve all serial numbers with their latest movements and associated posts
            $serialNumbers = serialNumber::with(['movements' => function ($query) {
                $query->latest('created_at')
                    ->select('id', 'serial_number_id', 'result', 'created_at', 'movement_post_id')
                    ->with('posts:id,post_name');
            }])->where('of_id', $of->id)->get()
                // Group serial numbers by their serial number
                ->groupBy('serial_number')
                // Map the grouped serial numbers to a new format with the latest movement and associated post
                ->map(function ($group) {
                    $lastMovement = $group->flatMap(function ($serialNumber) {
                        return $serialNumber['movements'];
                    })
                        ->sortByDesc('created_at')
                        ->first();

                    return [
                        'id' => $group->first()['id'],
                        'serial_number' => $group->first()['serial_number'],
                        'qr' => $group->first()['qr'],
                        'result' => $lastMovement['result'] ?? null,
                        'posts' => $lastMovement['posts']['post_name'] ?? null,
                    ];
                })->values()->all();

            // return $serialNumbers;
            return compact("of", "serialNumbers");

            // $serialNumbersWithLatestMovements = $groupedSerialNumbers->map(function ($group) {
            //     $lastMovement = $group->flatMap(function ($serialNumber) {
            //         return $serialNumber['movements'];
            //     })->sortByDesc('created_at')->first();

            //     return [
            //         'serial_number' => $group->first()['serial_number'],
            //         'qr' => $group->first()['qr'],
            //         'result' => $lastMovement["result"],
            //         'posts' => $lastMovement["posts"]["post_name"]
            //     ];
            // });

            // return $serialNumbersWithLatestMovements->values()->all();





            // return $orderedMovements;


            // // Access the serialNumbers collection of the OF
            // $serialNumbers = $of->serialNumbers;

            // // Loop through each serialNumber
            // foreach ($serialNumbers as $serialNumber) {
            //     // Access the movements collection of the serialNumber
            //     $movements = $serialNumber->movements;

            //     // If the serialNumber has at least one movement
            //     if ($movements->count() > 0) {
            //         // Access the first movement of the serialNumber (since the query above ordered them)
            //         $firstMovement = $movements->first();

            //         // Do something with the firstMovement record
            //         // For example, echo its description
            //         echo $firstMovement->description;
            //     }
            // }
            // return $serialNumbers;

            // return Of::with(['serialNumbers.movements' => fn ($q) => $q->select("*")->orderBy("movements.created_at")->first()])->find(1);
            // $of = Of::select("id", "of_number", "of_name", "status", "new_quantity", "caliber_id")
            //     ->with([
            //         "serialNumbers:of_id,qr",
            //         "caliber:id,caliber_name,product_id",
            //         "caliber.product:id,product_name,section_id",
            //         "caliber.product.section.posts" => function ($q) {
            //             $q->select("id", "post_name", "section_id");
            //             $q->where("section_id", 1);
            //             $q->withCount('movements');
            //         }
            //     ])->find(1);
            // $posts = $of->caliber->product->section->posts;
            // $posts->each(function ($post) {
            //     // return $post->posts;
            //     $post->movement_percentage = $post->movements_count / 4 * 100; # 4 is of quantity
            //     $post->stayed = 100 - $post->movement_percentage; # 4 is of quantity
            //     return $post;
            // });

            // return $of;
            //
            // Récupérer l'OF avec ses numéros de série et les informations de son calibre et du produit associé
            $of = Of::with([
                'serialNumbers' => fn ($q) => $q->select("id", "of_id", "qr")->where("valid", 1),
                'caliber.product.section.posts' => fn ($query) =>
                // Limiter les résultats aux posts de la section 1
                $query->where('section_id', 1)
                    ->select('id', 'post_name', 'section_id')
                    ->withCount('movements')
            ])
                ->select('id', 'of_number', 'of_name', 'status', 'new_quantity', 'caliber_id')
                ->find(1);

            $of_quantity = $of->new_quantity;
            $posts = $of->caliber->product->section->posts;
            // Calculer les pourcentages de mouvements et de stockage pour chaque post
            $posts->each(function ($post) use ($of_quantity) {
                $post->movement_percentage = $post->movements_count / $of_quantity * 100;
                $post->stayed = 100 - $post->movement_percentage;
            });

            // Retourner l'OF avec les informations des numéros de série et des posts
            return $of;


            // return   $of = Of::with(["serialNumbers", "caliber.product.section" => function ($q) {
            //     $q->where("section_id", 1);
            // }])->find(1);
            // $of = Of::with(["serialNumbers", "caliber.product" => function ($q) {
            //     $q->where("section_id", 1);
            // }])->find(1);

            // $of = OF::join("calibers", "ofs.caliber_id", "=", "calibers.id")
            //     ->get();

            $posts = Post::leftJoin('posts as a', 'posts.previous_post_id', '=', 'a.id')
                ->rightJoin('sections', 'posts.section_id', '=', 'sections.id')
                ->join('posts_types', 'posts.posts_type_id', '=', 'posts_types.id')
                ->where("posts.section_id", $of->caliber->product->section_id)
                ->get(['posts.id', 'posts.code', 'posts.post_name', 'posts_types.posts_type', 'sections.section_name', 'posts.ip_address', 'a.post_name as previous_post']);

            return compact("of", "posts");
        });
        // Route::get('test', function () {
        // return Movement::whereSerialNumberId(1)
        //     ->join("posts", "movement_post_id", "posts.id")
        //     ->get(["post_name", "result", "created_at"]);
        // });


        Route::get('dash', function () {
            // return Post::with("movements")->get();
            // $product_list = Of::select("id", "of_number", "new_quantity")->with("serialNumbers:of_id,qr")->get();



            $of = Of::with("serialNumbers:of_id,qr,valid")->find(1, ["id", "of_number", "new_quantity"]);
            // return   $posts = Post::select("id", "post_name", "code")->withCount("movements")->get();
            $posts = Post::select("id", "post_name", "code")->withCount('movements')
                // ->with(["movements" => function ($join) {
                // $join->join("posts", "movements.movement_post_id", "posts.id");
                // ->join("serial_numbers", "movements.serial_number_id", "serial_numbers.id")

                // ->select("movement_post_id", "result", "serial_number", "movements.created_at", "post_name");

                // ->whereIn("movements.created_at", function ($query) {
                //     $query->selectRaw("MAX(created_at)")
                //         ->from("movements")
                //         ->groupBy("serial_number_id");
                // });
                // }])
                ->get()
                ->map(function ($post) {
                    $post->movement_percentage = $post->movements_count / 4 * 100; # 4 is of quantity
                    $post->stayed = 100 - $post->movement_percentage; # 4 is of quantity
                    return $post;
                });
            return compact("of", "posts");
            // $result = $posts->movements->count();
            // return  $result["ofQr"] = Of::select("id", "of_number", "new_quantity")->with(["serialNumbers" => function ($q) {
            //     // $q->with("movements:serial_number_id,movement_post_id,result,created_at");
            //     $q->with(["movements" => function ($join) {
            //         $join->join("posts", "movements.movement_post_id", "posts.id");
            //         $join->select("created_at", "result", "serial_number_id", "post_name");
            //     }]);
            // }])->find(1);

            // $result["posts"] = Movement::join("posts", "movements.movement_post_id", "posts.id")->whereSectionId(1)->get();

            // return $result;
        });

        // route::get('serial_numbers/qr_life/{id}', [SerialNumberController::class, 'productLife']);

        route::get("sn_dash", function () {
            return Movement::whereSerialNumberId(1)
                ->join("posts", "movement_post_id", "posts.id")
                ->get(["post_name", "result", "created_at"]);
        });
    }
);
