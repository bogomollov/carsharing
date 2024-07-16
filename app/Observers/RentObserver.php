<?php

namespace App\Observers;

use App\Models\Rent;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache as Redis;

class RentObserver
{
    /**
     * Handle the Rent "created" event.
     */
    public function created(Rent $rent): void
    {
        Redis::forget('rent_index');
    }

    /**
     * Handle the Rent "updated" event.
     */
    public function updated(Rent $rent): void
    {
        Redis::forget('rent_index');
    }

    /**
     * Handle the Rent "deleted" event.
     */
    public function deleted(Rent $rent): void
    {
        Redis::forget('rent_index');
    }

    /**
     * Handle the Rent "restored" event.
     */
    public function restored(Rent $rent): void
    {
        Redis::forget('rent_index');
    }

    /**
     * Handle the Rent "force deleted" event.
     */
    public function forceDeleted(Rent $rent): void
    {
        Redis::forget('rent_index');
    }
}
