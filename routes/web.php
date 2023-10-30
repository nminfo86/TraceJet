<?php

use App\Models\Of;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Caliber;
use App\Models\Product;
use App\Models\Section;
use App\Models\Movement;
use App\Models\SerialNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\Api\v1\SerialNumberController;
use Illuminate\Support\Facades\Cache;
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
    return view('pages.login');
})->name('login');
/****************************** ***********************/


/*************************route to authenticate ******************/
Route::post('authLogin', [WebAuthController::class, 'webLogin']);
/************************** end ************************************/

// /*************************route to logout ******************/
// Route::get('logout', [WebAuthController::class, 'webLogout']);
// /************************** end ************************************/



//     function () {
Route::group(
    ['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {
        Route::get('/dashboard', function () {
            return view('welcome');
        });
        Route::get('/logout', [WebAuthController::class, 'webLogout'])->name('logout');

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
        })->middleware(['permission:post-list']);
        Route::get('printers', function () {
            return view('pages.printers');
        }); //->middleware(['permission:printer-list']);
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
            return view('pages.serial_numbers');
        })->middleware('permission:serial_number-list');
        Route::get('packaging', function () {
            return view('pages.packaging');
        })->middleware('permission:packaging-list');
        Route::get('operators', function () {
            return view('pages.operators');
        })->middleware('permission:movement-list');

        Route::get('repairs', function () {
            return view('pages.repairs');
        })->middleware('permission:movement-list');

        route::get("test2/['param1' => 'value1', 'param2' => 'value2']", function ($req) {
            dd($req->all());
        });

        Route::get('test', function () {


            // Récupérer l'OF avec ses numéros de série et les informations de son calibre et du produit associé
            $of = Of::with([
                // 'serialNumbers' => fn ($q) => $q->select("id", "of_id", "qr")->where("valid", 1),
                'caliber.product.section.posts' => fn ($q) =>
                // Limiter les résultats aux posts de la section 1
                // $query->where('section_id', 1)
                $q->orderByDesc("post_name")
                    ->select('id', 'post_name', 'code', 'section_id', 'color')
                    ->withCount('movements')
            ])
                ->select('id', 'of_number', 'of_name', 'status', 'new_quantity', 'caliber_id')
                ->find(1);

            $posts = $of->caliber->product->section->posts;
            $quantity = $of->new_quantity;
            $of->caliber->product->section->posts->map(function ($post) use ($quantity) {
                $post->movement_percentage = $post->movements_count / $quantity * 100;
                $post->stayed = 100 - $post->movement_percentage;
                return $post;
            });


            // Retrieve all serial numbers with their latest movements and associated posts
            $serialNumbers = serialNumber::with(['movements' => function ($query) {
                $query->latest('created_at')
                    ->select('id', 'serial_number_id', 'result', 'created_at', 'movement_post_id')
                    ->with('posts:id,post_name,color');
            }])->where([['of_id', $of->id], ["valid", 1]])->get()
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
                        'color' => $lastMovement['posts']['color'] ?? null,
                    ];
                })->values()->all();

            /* -------------------------------------------------------------------------- */
            /*                               Taux avancement                              */
            /* -------------------------------------------------------------------------- */
            $section_id = $of->caliber->product->section_id;
            $count = Movement::join('posts', 'movements.movement_post_id', '=', 'posts.id')
                ->where('posts.section_id', '=', $section_id)
                ->where('posts.posts_type_id', '=', 3)
                ->count('movements.serial_number_id');
            $of->taux =  $count / $quantity * 100 . "%";
            // return $serialNumbers;
            return   compact("of", "serialNumbers");
        });


        Route::get('dash', function () {
            $of = Of::with([
                // 'serialNumbers' => fn ($q) => $q->select("id", "of_id", "qr")->where("valid", 1),
                'caliber.product.section.posts' => fn ($q) =>
                // Limiter les résultats aux posts de la section 1
                // $query->where('section_id', 1)
                $q->orderByDesc("post_name")
                    ->select('id', 'post_name', 'code', 'section_id')
                    ->withCount('movements')
            ])
                ->select('id', 'of_number', 'of_name', 'status', 'new_quantity', 'caliber_id')
                ->find(1);


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
            // return Post::with("movements")->get();
            // $product_list = Of::select("id", "of_number", "new_quantity")->with("serialNumbers:of_id,qr")->get();



            // $of = Of::with("serialNumbers:of_id,qr,valid")->find(1, ["id", "of_number", "new_quantity"]);
            // // return   $posts = Post::select("id", "post_name", "code")->withCount("movements")->get();
            // $posts = Post::select("id", "post_name", "code")->withCount('movements')
            //     // ->with(["movements" => function ($join) {
            //     // $join->join("posts", "movements.movement_post_id", "posts.id");
            //     // ->join("serial_numbers", "movements.serial_number_id", "serial_numbers.id")

            //     // ->select("movement_post_id", "result", "serial_number", "movements.created_at", "post_name");

            //     // ->whereIn("movements.created_at", function ($query) {
            //     //     $query->selectRaw("MAX(created_at)")
            //     //         ->from("movements")
            //     //         ->groupBy("serial_number_id");
            //     // });
            //     // }])
            //     ->get()
            //     ->map(function ($post) {
            //         $post->movement_percentage = $post->movements_count / 4 * 100; # 4 is of quantity
            //         $post->stayed = 100 - $post->movement_percentage; # 4 is of quantity
            //         return $post;
            //     });
            // return compact("of", "posts");


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

        route::get("t", function () {
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

                ->groupBy('movements.movement_post_id', 'posts.post_name')
                ->get();

            // Calculate total FPY for the chain
            $total_fpy = $fpy->reduce(fn ($carry, $item) => $carry * ($item->FPY / 100), 1) * 100;

            // Return the results
            return compact("ofs", "fpy", "total_fpy");



            // $request = ["of_id" => 1, "start_date" => "2023-05-01 00:00:00", "end_date" => "2023-11-11 23:23:23"];
            // // $request  = json_encode($arr);
            // // dd($request);
            // // $ofs = Of::with("caliber.product")->get();
            // // $ofs = Of::select('of_name', 'caliber_id')->with("caliber.product.section")

            // // ->addSelect('caliber.product.section.section_name')
            // // ->get();

            // $query = Movement::join('posts', 'movements.movement_post_id', '=', 'posts.id')
            //     ->join('serial_numbers', 'movements.serial_number_id', '=', 'serial_numbers.id');

            // // Apply condition: Filter by 'of_id' if present in the request


            // // Perform grouping and select statements
            // $query->groupBy('movement_post_id')
            //     ->select('posts.post_name')
            //     ->selectRaw('COUNT(IF(movements.result = "OK", 1, NULL)) AS count_ok')
            //     ->selectRaw('COUNT(IF(movements.result = "NOK", 1, NULL)) AS count_nok')
            //     ->selectRaw('(COUNT(CASE WHEN movements.result = "OK" THEN 1 END) / COUNT(*)) * 100 AS FPY');

            // // Execute the query and retrieve the results
            // $result = $query->toSql();

            // Convert FPY values to integers
            // $result->transform(function ($item) {
            //     $item->FPY = round($item->FPY, 4); // Round FPY to 4 decimal places
            //     return $item;
            // });

            // // Calculate total FPY
            $total_fpy = $fpy->reduce(fn ($carry, $item) => $carry * ($item->FPY / 100), 1) * 100;

            // // Add total FPY to the result array
            // $result->push([
            //     'post_name' => 'Total',
            //     'count_ok' => $result->sum('count_ok'),
            //     'count_nok' => $result->sum('count_nok'),
            //     'FPY' => round($totalFPY, 4),
            // ]);

            // Return the result
            // return $result;

            // $ofs = $ofs->map(function ($of) {
            //     return [
            //         'id' => $of->id,
            //         'of_name' => $of->of_name,
            //         'section_name' => $of->caliber->product->section->section_name
            //     ];
            // });

            // return $ofs;
            // $result = Movement::join('posts', 'movements.movement_post_id', '=', 'posts.id')
            //     ->join('serial_numbers', 'movements.serial_number_id', '=', 'serial_numbers.id')
            //     ->where('serial_numbers.of_id', 1) // Filter by specific of_id
            //     ->whereBetween('movements.created_at', ['2023-05-01 00:00:00', '2023-05-31 00:00:00']) // Filter by date range
            //     ->groupBy('movement_post_id') // Group by movement_post_id
            //     ->select('posts.post_name') // Select the post_name column
            //     ->selectRaw('COUNT(IF(movements.result = "OK", 1, NULL)) AS count_ok') // Count occurrences of "OK"
            //     ->selectRaw('COUNT(IF(movements.result = "NOK", 1, NULL)) AS count_nok') // Count occurrences of "NOK"
            //     ->get(); // Retrieve the results

            // Initialize the base query
            // $query = Movement::join('posts', 'movements.movement_post_id', '=', 'posts.id')
            //     ->join('serial_numbers', 'movements.serial_number_id', '=', 'serial_numbers.id');

            // // Apply condition: Filter by 'of_id' if present in the request
            // if ($request["of_id"] != "") {
            //     $ofId = $request["of_id"];
            //     $query->where('serial_numbers.of_id', $ofId);
            // }

            // // Apply condition: Filter by 'date' if present in the request
            // if ($request["start_date"] != "" && $request["end_date"] != "") {

            //     $startDate = $request["start_date"];
            //     $endDate = $request["end_date"];
            //     $query->whereBetween('movements.created_at', [$startDate, $endDate]);
            // }

            // // Perform grouping and select statements
            // $query->groupBy('movement_post_id')
            //     ->select('posts.post_name')
            //     ->selectRaw('COUNT(IF(movements.result = "OK", 1, NULL)) AS count_ok')
            //     ->selectRaw('COUNT(IF(movements.result = "NOK", 1, NULL)) AS count_nok')
            //     ->selectRaw('(COUNT(CASE WHEN movements.result = "OK" THEN 1 END) / COUNT(*)) * 100 AS FPY');

            // // Execute the query and retrieve the results
            // $result = $query->get();



            // // Convert FPY values to integers
            // $result->transform(function ($item) {
            //     $item->FPY = (int) $item->FPY;
            //     return $item;
            // });

            // // Calculate FPY of the total posts
            // $result['totalFPY'] = $result->sum('FPY') / count($result);
            // $total_ok = 0;
            // $result = $result->map(function ($of) {
            //     return [
            //         'id' => $of->post_name,
            //         'count_ok' => $of->count_ok,
            //         'count_nok' => $of->count_nok,
            //         'FPY' => ($of->count_ok / ($of->count_ok + $of->count_nok)) * 100
            //     ];
            // });

            // The $result variable now contains the queried data with eager loaded 'post' relationship

            // Add appropriate comments explaining the purpose and result of the code

            // $query = Movement::join('posts', 'movements.movement_post_id', '=', 'posts.id')
            //     ->join('serial_numbers', 'movements.serial_number_id', '=', 'serial_numbers.id');

            // // Apply condition: Filter by 'of_id' if present in the request
            // if ($request["of_id"]) {
            //     $ofId = $request["of_id"];
            //     $query->where('serial_numbers.of_id', $ofId);
            // }

            // // Apply condition: Filter by 'date' if present in the request
            // if ($request["start_date"] != "" && $request["end_date"] != "") {
            //     $startDate = $request["start_date"];
            //     $endDate = $request["end_date"];
            //     $query->whereBetween('movements.created_at', [$startDate, $endDate]);
            // }

            // // Perform grouping and select statements
            // $query->groupBy('movement_post_id')
            //     ->select('posts.post_name')
            //     ->selectRaw('COUNT(IF(movements.result = "OK", 1, NULL)) AS count_ok')
            //     ->selectRaw('COUNT(IF(movements.result = "NOK", 1, NULL)) AS count_nok')
            //     ->selectRaw('(COUNT(CASE WHEN movements.result = "OK" THEN 1 END) / COUNT(*)) * 100 AS FPY');

            // // Execute the query and retrieve the results
            // $result = $query->get();

            // // Convert FPY values to integers
            // $result->transform(function ($item) {
            //     $item->FPY = round($item->FPY, 4); // Round FPY to 4 decimal places
            //     return $item;
            // });

            // // Calculate total FPY
            // $totalFPY = $result->sum('FPY');

            // // Calculate total FPY percentage
            // $totalFPYPercentage = round(($totalFPY / count($result)), 4);

            // // Add total FPY to the result array
            // $result->push([
            //     'post_name' => 'Total',
            //     'count_ok' => $result->sum('count_ok'),
            //     'count_nok' => $result->sum('count_nok'),
            //     'FPY' => $totalFPYPercentage,
            // ]);

            // // Return the result
            // return $result;

            return compact("ofs", "fpy", "total_fpy");


            // $products = Product::where('category_id', $categoryId)
            //     ->orWhere('price', '>', 100)
            //     ->orWhere(function ($query) {
            //         $query->where('brand', 'Nike')
            //             ->orWhere('brand', 'Adidas');
            //     })
            //     ->get();
            // $sectionId = 3;

            // // $query->whereHas('caliber.product', fn ($q) => $q->where('section_id', $sectionId))->toSql();


            // $ofs = Of::where('status', 'new')
            //     ->whereHas('caliber', function ($query) use ($sectionId) {
            //         $query->whereHas('product', function ($query) use ($sectionId) {
            //             $query->where('section_id', $sectionId);
            //         });
            //     })
            //     ->get();

            // return  Of::filterBySection()->where("status", "new")->orWhere("status", "inProd")->get();

            // return  Of::filterBySection()->where("status", "inProd")->orWhere("status", "new")->pluck('of_name', 'id');
            // // dd(Session::all());
            // return Of::filterBySection()->get();
            // return $products = Product::filterBySection()->get();
        });


        route::get("p", function () {
            return Caliber::whereProductId(2)->join('products', 'calibers.product_id', 'products.id')->select(DB::raw("CONCAT(product_name, ' ', caliber_code) as product"))->first();
            // Créez une instance du contrôleur
            $controller = new \App\Http\Controllers\Controller;

            // Appelez la méthode `postsListFromCache(3)`
            $current_post = $controller->postsListFromCache(3);


            if ($current_post["status"] == false) {
                // Handle the case where the post does not exist in the user's section
                return $this->sendResponse($current_post["message"], status: false);
            }

            return "suite";
            // Continue with the rest of your code
            $valid_products = SerialNumber::whereOfId($request->of_id)->whereValid(1)
                ->get(["serial_number", "updated_at"]);

            // Get the quantity of valid serial numbers for today
            $quantity_valid_for_today = $valid_products->filter(function ($item) {
                return date('Y-m-d', strtotime($item['updated_at'])) == Carbon::today()->toDateString();
            })->count();

            // Prepare the response data
            $data = [
                'list' => $valid_products,
                'quantity_of_day' => "0" . $quantity_valid_for_today
            ];

            // Return the response
            return $this->sendResponse(data: $data);
        });
    }
);
