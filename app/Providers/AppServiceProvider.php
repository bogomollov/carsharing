<?php

namespace App\Providers;
use App\Models\Car;
use App\Models\Arendator;
use App\Models\Bill;
use App\Observers\CarObserver;
use App\Observers\ArendatorObserver;
use App\Observers\BillObserver;
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
        Bill::observe(BillObserver::class);
    }
}
