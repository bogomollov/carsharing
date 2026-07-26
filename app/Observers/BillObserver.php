<?php

namespace App\Observers;

use App\Models\Bill;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache as Redis;

class BillObserver implements ShouldHandleEventsAfterCommit
{
    public function created(Bill $bill): void
    {
        Redis::forget('bill_index');
    }

    public function updated(Bill $bill): void
    {
        Redis::forget('bill_index');
        Redis::forget($bill->id);
    }

    public function deleted(Bill $bill): void
    {
        Redis::forget('bill_index');
        Redis::forget($bill->id);
    }

    public function restored(Bill $bill): void
    {
        Redis::forget('bill_index');
    }

    public function forceDeleted(Bill $bill): void
    {
        Redis::forget('bill_index');
    }
}
