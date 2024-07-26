<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Cache as Redis;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        Redis::forget($transaction);
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        Redis::forget($transaction);
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
    }
}
