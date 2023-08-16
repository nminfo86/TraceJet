<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Of;
use App\Models\Post;
use App\Models\Movement;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        // $request["caliber_id"] = "";
        $posts = Post::whereSectionId($request->section_id)->get(["id", "post_name"]);


        // Apply condition: Filter by 'start_date' and 'end_date' if present in the request
        $fpy = Movement::join('posts', 'movements.movement_post_id', '=', 'posts.id')
            ->join('posts_types', 'posts.posts_type_id', '=', 'posts_types.id')
            ->join('serial_numbers', 'movements.serial_number_id', '=', 'serial_numbers.id')

            // ->when($request->start_date !== "" && $request->end_date !== "", function ($query) use ($request) {
            //     return $query->whereBetween('movements.created_at', [$request->start_date, $request->end_date]);
            // })

            ->when($request->caliber_id, function ($query) use ($request) {
                $query->join('ofs', 'serial_numbers.of_id', '=', 'ofs.id')->where('caliber_id', $request->caliber_id);
            })
            ->when($request->of_id, function ($query) use ($request) {
                $query->where('serial_numbers.of_id', $request->of_id);
            })
            ->where(function ($query) {
                // Filter out duplicate rows based on the minimum id
                $query->whereRaw('movements.id = (SELECT MIN(id) FROM movements AS m WHERE m.movement_post_id = movements.movement_post_id AND m.serial_number_id = movements.serial_number_id)');
            })
            // ->join('posts', 'movements.movement_post_id', '=', 'posts.id')
            // ->join('serial_numbers', 'movements.serial_number_id', '=', 'serial_numbers.id')
            ->select('posts.id', 'posts.post_name', "posts.posts_type_id", 'icon')
            ->selectRaw('COUNT(IF(movements.result = "OK", 1, NULL)) AS count_ok')
            ->selectRaw('COUNT(IF(movements.result = "NOK", 1, NULL)) AS count_nok')
            ->selectRaw('CAST((COUNT(CASE WHEN movements.result = "OK" THEN 1 END) / COUNT(*)) * 100 AS UNSIGNED) AS FPY')
            ->groupBy('movements.movement_post_id', 'posts.post_name', "posts.id", "posts.posts_type_id", 'icon')
            ->get();



        $fpyPosts = $fpy->pluck('post_name')->toArray();

        $unmatchedPosts = $posts->reject(function ($post) use ($fpyPosts) {
            return in_array($post['post_name'], $fpyPosts);
        });

        $unmatchedPosts = $unmatchedPosts->values()->each(function ($unmatchedPost) {
            $unmatchedPost->count_ok = 0;
            $unmatchedPost->count_nok = 0;
            $unmatchedPost->FPY = 0;
        });

        $fpy = Arr::collapse([$fpy, $unmatchedPosts]);


        // return ($unmatchedPosts);
        if ($fpy) {



            // dd($fpy);
            # code...
            // Calculate total FPY for the chain
            $total_fpy = collect($fpy)->reduce(fn ($carry, $item) => $carry * ($item->FPY / 100), 1) * 100;
            return $this->sendResponse(data: compact("fpy", "total_fpy"));
        }
        return $this->sendResponse("Empty FPY", status: false);

        // Return the results
    }



    public function ofsListBySection($sectionId)
    {
        $ofs = Of::inSection($sectionId)->get(['of_number', 'of_code', 'status', 'id']);
        return $this->sendResponse(data: $ofs);
    }
}
