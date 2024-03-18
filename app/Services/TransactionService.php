<?php

namespace App\Services;

use App\Models\Arendator;
use App\Models\Bill;
use App\Models\Transaction;

class TransactionService
{
     /**
     * Создает запись в истории со счетами
     *
     * @param Bill $bill Связанный счет
     * @param Arendator $renter Инициатор транзакции
     * @param int $modification Изменение (положительное или отрицатеьлное число) в копейках
     * @param string $reason Причина (описание) транзакции
     */
    public function createRecord(Bill $bill, Arendator $renter, int $modification) {
        $transaction = new Transaction();
        $transaction->createRecord(
            $bill,
            $renter,
            $modification,
        );
    }
}