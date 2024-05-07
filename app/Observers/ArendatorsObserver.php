<?php

namespace App\Observers;
use Illuminate\Support\Facades\Cache;
use App\Models\Arendator;

class ArendatorsObserver
{
    /**
     * Handle the Arendators "created" event.
     */
    public function created(Arendator $arendators): void
    {
        Cache::forget('arendators:all');
    }

    /**
     * Handle the Arendators "saved" event.
     */
    public function saved(Arendator $arendators): void
    {
        Cache::forget('arendators:all');
    }

    /**
     * Handle the Arendators "updated" event.
     */
    public function updated(Arendator $arendators): void
    {
        Cache::forget('arendators:all');
    }

    /**
     * Handle the Arendators "deleted" event.
     */
    public function deleted(Arendator $arendators): void
    {
        Cache::forget('arendators:all');
    }

    /**
     * Handle the Arendators "deleting" event.
     */
    // public function deleting(Arendators $arendators): void
    // {
    //     Cache::forget('arendators:all');
    // }

    /**
     * Handle the Cars "retrieved" event.
     */
    // public function retrieved(Arendators $arendators): void
    // {
    //     Cache::forget('arendators:all');
    // }

    /**
     * Handle the Arendators "restored" event.
     */
    // public function restored(Arendators $arendators): void
    // {
    //     Cache::forget('arendators:all');
    // }

    public function forceDeleted(Arendator $arendators): void
    {
        Cache::forget('arendators:all');
    }
}
