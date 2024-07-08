<?php

namespace App\Observers;

use App\Models\Bill;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class BillObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Bill "created" event.
     */
    public function created(Bill $bill): void
    {
        
    }

    /**
     * Handle the Bill "updated" event.
     */
    public function updated(Bill $bill): void
    {
        $bill->bills();
        $bill->updateRentersCount();
        $bill->updateBillType();
    }

    /**
     * Handle the Bill "deleted" event.
     */
    public function deleted(Bill $bill): void
    {
        $bill->bills();
        $bill->updateRentersCount();
        $bill->updateBillType();
    }

    /**
     * Handle the Bill "restored" event.
     */
    public function restored(Bill $bill): void
    {
        $bill->bills();
        $bill->updateRentersCount();
        $bill->updateBillType();
    }

    /**
     * Handle the Bill "force deleted" event.
     */
    public function forceDeleted(Bill $bill): void
    {
        $bill->bills();
        $bill->updateRentersCount();
        $bill->updateBillType();
    }
}
