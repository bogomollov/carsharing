<?php

namespace App\Providers;
use App\Models\Cars;
use App\Models\Arendators;
use App\Observers\CarsObserver;
use App\Observers\ArendatorsObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cars::observe(CarsObserver::class);
        Arendators::observe(ArendatorsObserver::class);
    }
}
