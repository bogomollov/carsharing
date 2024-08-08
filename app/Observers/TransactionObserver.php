<?php

namespace App\Observers;

use App\Models\Bill;
use App\Models\Transaction;
use App\Services\BillService;
use Illuminate\Support\Facades\Cache as Redis;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        $billService = new BillService();
        $billService->modificateBalance(Bill::find($transaction->bill_id), $transaction->modification);
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        Redis::forget($transaction);
        $billService = new BillService();
        $billService->modificateBalance(Bill::find($transaction->bill_id), $transaction->modification);
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        Redis::forget($transaction);
        $billService = new BillService();
        $billService->modificateBalance(Bill::find($transaction->bill_id), -$transaction->modification);
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        $billService = new BillService();
        $billService->modificateBalance(Bill::find($transaction->bill_id), -$transaction->modification);
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        $billService = new BillService();
        $billService->modificateBalance(Bill::find($transaction->bill_id), -$transaction->modification);
    }
}
