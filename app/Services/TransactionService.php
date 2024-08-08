<?php

namespace App\Services;

use App\Models\Arendator;
use App\Models\Bill;
use App\Models\Transaction;

class TransactionService
{
    public function createTransaction(Arendator $arendator, Bill $bill, float $modification) {
        Transaction::create([
            'arendator_id' => $arendator->id,
            'bill_id' => $bill->id,
            'modification' => $modification,
        ]);
    }
}