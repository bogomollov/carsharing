<?php

namespace App\Observers;

use App\Models\Bill;
use App\Models\Transaction;
use App\Services\BillService;
use Illuminate\Support\Facades\Cache as Redis;

class TransactionObserver
{
    
    public function created(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        $billService = new BillService();
        $billService->modificateBalance(Bill::find($transaction->bill_id), $transaction->modification);
    }

    
    public function updated(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        Redis::forget($transaction->id);
        $billService = new BillService();
        $billService->modificateBalance(Bill::find($transaction->bill_id), $transaction->modification);
    }

    
    public function deleted(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        Redis::forget($transaction->id);
        $billService = new BillService();
        $billService->modificateBalance(Bill::find($transaction->bill_id), -$transaction->modification);
    }

    
    public function restored(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        $billService = new BillService();
        $billService->modificateBalance(Bill::find($transaction->bill_id), -$transaction->modification);
    }

    
    public function forceDeleted(Transaction $transaction): void
    {
        Redis::forget('transaction_index');
        $billService = new BillService();
        $billService->modificateBalance(Bill::find($transaction->bill_id), -$transaction->modification);
    }
}
