<?php

namespace App\Providers;

use App\Models\Of;
use Carbon\Carbon;
use App\Observers\OfObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //ADD by nminfo to prevent migration run error in my mysql version
        Schema::defaultStringLength(191);
        // Carbon::setTimezone('Europe/Paris');
        // JsonResource::withoutWrapping();
        //
    }
}
