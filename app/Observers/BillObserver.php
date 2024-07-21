<?php

namespace App\Observers;

use App\Models\Bill;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache as Redis;

class BillObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Bill "created" event.
     */
    public function created(Bill $bill): void
    {
        Redis::forget('bill_index');
    }

    /**
     * Handle the Bill "updated" event.
     */
    public function updated(Bill $bill): void
    {
        Redis::forget('bill_index');
    }

    /**
     * Handle the Bill "deleted" event.
     */
    public function deleted(Bill $bill): void
    {
        Redis::forget('bill_index');
    }

    /**
     * Handle the Bill "restored" event.
     */
    public function restored(Bill $bill): void
    {
        Redis::forget('bill_index');
    }

    /**
     * Handle the Bill "force deleted" event.
     */
    public function forceDeleted(Bill $bill): void
    {
        Redis::forget('bill_index');
    }
}
