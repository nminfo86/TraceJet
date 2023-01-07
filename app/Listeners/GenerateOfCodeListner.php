<?php

namespace App\Listeners;

use App\Models\Of;
use App\Events\CreateOfEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateOfCodeListner implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  App\Events\CreateOfEvent  $event
     * @return void
     */
    public function handle(CreateOfEvent $event)
    {
        //
        // dd($event->of->id);

        $generate_of_code = $event->of::join('calibers', 'ofs.caliber_id', '=', 'calibers.id')
            ->join('products', 'calibers.product_id', '=', 'products.id')
            ->join('sections', 'products.section_id', '=', 'sections.id')
            ->where('ofs.id', $event->of->id)
            // ->get(['ofs.of_number', 'calibers.caliber_code', 'products.product_code', 'sections.section_name']);
            ->select(DB::raw("CONCAT(sections.section_code,products.product_code, calibers.caliber_code, ofs.of_number, year(now())) AS of_code"))->first();
        // dd($generate_of_code);
        $event->of->of_code = $generate_of_code->of_code;
        $event->of->save();
    }
}