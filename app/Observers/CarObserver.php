<?php

namespace App\Observers;
use Illuminate\Support\Facades\Cache as Redis;
use App\Models\Car;

class CarObserver
{
    public function created(Car $car): void
    {
        Redis::forget('car_index');
    }

    public function saved(Car $car): void
    {
        Redis::forget('car_index');
    }

    public function updated(Car $car): void
    {
        Redis::forget('car_index');
        Redis::forget($car->id);
    }

    public function deleted(Car $car): void
    {
        Redis::forget('car_index');
        Redis::forget($car->id);
    }

    public function deleting(Car $car): void
    {
        Redis::forget('car_index');
    }

    public function restored(Car $car): void
    {
        Redis::forget('car_index');
    }

    public function forceDeleted(Car $car): void
    {
        Redis::forget('car_index');
    }
}
