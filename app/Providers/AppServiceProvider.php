<?php

namespace App\Providers;
use App\Models\Car;
use App\Models\Arendator;
use App\Observers\CarObserver;
use App\Observers\ArendatorObserver;
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
        Car::observe(CarObserver::class);
        Arendator::observe(ArendatorObserver::class);
    }
}
