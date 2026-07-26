<?php

namespace App\Providers;
use App\Models\Car;
use App\Models\Arendator;
use App\Models\Bill;
use App\Models\Rent;
use App\Models\Transaction;
use App\Observers\CarObserver;
use App\Observers\ArendatorObserver;
use App\Observers\BillObserver;
use App\Observers\RentObserver;
use App\Observers\TransactionObserver;
use Illuminate\Http\Resources\Json\JsonResource;
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
        Rent::observe(RentObserver::class);
        Transaction::observe(TransactionObserver::class);
    }
}
