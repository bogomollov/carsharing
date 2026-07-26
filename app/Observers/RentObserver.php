<?php

namespace App\Observers;

use App\Models\Rent;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache as Redis;

class RentObserver
{
    
    public function created(Rent $rent): void
    {
        Redis::forget('rent_index');
    }

    
    public function updated(Rent $rent): void
    {
        Redis::forget('rent_index');
        Redis::forget($rent->id);
    }

    
    public function deleted(Rent $rent): void
    {
        Redis::forget('rent_index');
        Redis::forget($rent->id);
    }

    
    public function restored(Rent $rent): void
    {
        Redis::forget('rent_index');
    }

    
    public function forceDeleted(Rent $rent): void
    {
        Redis::forget('rent_index');
    }
}
