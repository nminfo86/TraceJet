<?php

namespace App\Http\Controllers\Api\v1;

use stdClass;
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
        $posts = Post::whereSectionId($request->section_id)->join('posts_types', 'posts.posts_type_id', '=', 'posts_types.id')->get(["posts.id", "post_name", "icon", "color"]);


        // Apply condition: Filter by 'start_date' and 'end_date' if present in the request
        $fpy = Movement::join('serial_numbers', 'movements.serial_number_id', '=', 'serial_numbers.id')

            ->when($request->start_date !== "" && $request->end_date !== "", function ($query) use ($request) {
                return $query->whereBetween('movements.created_at', [$request->start_date, $request->end_date]);
            })

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
            ->select('movement_post_id as id')
            ->selectRaw('COUNT(IF(movements.result = "OK", 1, NULL)) AS count_ok')
            ->selectRaw('COUNT(IF(movements.result = "NOK", 1, NULL)) AS count_nok')
            ->selectRaw('CAST((COUNT(CASE WHEN movements.result = "OK" THEN 1 END) / COUNT(*)) * 100 AS UNSIGNED) AS FPY')
            ->groupBy('movement_post_id')
            ->get();

        // $arr = [];
        $arr = new stdClass();

        foreach ($posts as $post) {
            $found = false;

            foreach ($fpy as &$item) {
                // dd($post['id'] === $item["id"]);

                if ($post->id === $item->id) {
                    $item->post_name = $post->post_name;
                    $item->icon = $post->icon;
                    $item->color = $post->color;
                    $found = true;
                    //dd($item);
                    break;
                }
            }
            //dd($fpy);

            if (!$found) {
                $obj = new stdClass();
                $obj->id = $post->id;
                $obj->count_ok = 0;
                $obj->count_nok = 0;
                $obj->FPY = 0;
                $obj->post_name = $post->post_name;
                $obj->icon = $post->icon;
                $obj->color = $post->color;
                $fpy[] = $obj;
            }
        }

        if ($fpy) {
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
