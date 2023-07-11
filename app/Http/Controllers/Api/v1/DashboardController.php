<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Of;
use App\Models\Movement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        // $ofs = Of::inSection($request->section_id)
        //     // Apply condition: Filter by 'of_id' if present in the request
        //     ->when($request->has('of_id'), function ($query) use ($request) {
        //         return $query->where('id', $request->of_id);
        //     })
        //     ->get(['id', 'of_name']);
        $fpy = Movement::when($request->has('start_date') && $request->has('end_date'), function ($query) use ($request) {
            // Apply condition: Filter by 'start_date' and 'end_date' if present in the request
            return $query->whereBetween('movements.created_at', [$request->start_date, $request->end_date]);
        })
            // ->when($request->has('caliber'), function ($query) use ($request) {
            //     // Apply condition: Filter by 'start_date' and 'end_date' if present in the request
            //     return $query->whereBetween('movements.created_at', [$request->start_date, $request->end_date]);
            // })
            ->where(function ($query) {
                // Filter out duplicate rows based on the minimum id
                $query->whereRaw('movements.id = (SELECT MIN(id) FROM movements AS m WHERE m.movement_post_id = movements.movement_post_id AND m.serial_number_id = movements.serial_number_id)');
            })
            ->join('posts', 'movements.movement_post_id', '=', 'posts.id')
            ->join('serial_numbers', 'movements.serial_number_id', '=', 'serial_numbers.id')
            ->groupBy('movements.movement_post_id', 'posts.post_name')
            ->select('posts.post_name')
            ->selectRaw('COUNT(IF(movements.result = "OK", 1, NULL)) AS count_ok')
            ->selectRaw('COUNT(IF(movements.result = "NOK", 1, NULL)) AS count_nok')
            ->selectRaw('CAST((COUNT(CASE WHEN movements.result = "OK" THEN 1 END) / COUNT(*)) * 100 AS UNSIGNED) AS FPY')
            ->get();

        if ($fpy) {
            // dd($fpy);
            # code...
            // Calculate total FPY for the chain
            $total_fpy = $fpy->reduce(fn ($carry, $item) => $carry * ($item->FPY / 100), 1) * 100;
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
