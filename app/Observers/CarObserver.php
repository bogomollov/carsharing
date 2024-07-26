<?php

namespace App\Observers;
use Illuminate\Support\Facades\Cache as Redis;
use App\Models\Car;

class CarObserver
{
    /**
     * Handle the Cars "created" event.
     */
    public function created(Car $car): void
    {
        Redis::forget('car_index');
    }

    /**
     * Handle the Cars "saved" event.
     */
    public function saved(Car $car): void
    {
        Redis::forget('car_index');
    }

    /**
     * Handle the Cars "updated" event.
     */
    public function updated(Car $car): void
    {
        Redis::forget('car_index');
        Redis::forget($car);
    }

    /**
     * Handle the Cars "deleted" event.
     */
    public function deleted(Car $car): void
    {
        Redis::forget('car_index');
        Redis::forget($car);
    }

    /**
     * Handle the Cars "deleting" event.
     */
    public function deleting(Car $car): void
    {
        Redis::forget('car_index');
    }

    /**
     * Handle the Cars "retrieved" event.
     */
    public function retrieved(Car $car): void
    {
        Redis::forget('car_index');
    }

    /**
     * Handle the Cars "restored" event.
     */
    public function restored(Car $car): void
    {
        Redis::forget('car_index');
    }

    public function forceDeleted(Car $car): void
    {
        Redis::forget('car_index');
    }
}
