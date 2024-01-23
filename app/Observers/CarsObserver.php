<?php

namespace App\Observers;
use Illuminate\Support\Facades\Cache;
use App\Models\Cars;

class CarsObserver
{
    /**
     * Handle the Cars "created" event.
     */
    public function created(Cars $cars): void
    {
        Cache::forget('cars:all');
    }

    /**
     * Handle the Cars "saved" event.
     */
    public function saved(Cars $cars): void
    {
        Cache::forget('cars:all');
    }

    /**
     * Handle the Cars "updated" event.
     */
    public function updated(Cars $cars): void
    {
        Cache::forget('cars:all');
    }

    /**
     * Handle the Cars "deleted" event.
     */
    public function deleted(Cars $cars): void
    {
        Cache::forget('cars:all');
    }

    /**
     * Handle the Cars "deleting" event.
     */
    // public function deleting(Cars $cars): void
    // {
    //     Cache::forget('cars:all');
    // }

    /**
     * Handle the Cars "retrieved" event.
     */
    // public function retrieved(Cars $cars): void
    // {
    //     Cache::forget('cars:all');
    // }

    /**
     * Handle the Cars "restored" event.
     */
    // public function restored(Cars $cars): void
    // {
    //     Cache::forget('cars:all');
    // }

    public function forceDeleted(Cars $cars): void
    {
        Cache::forget('cars:all');
    }
}
