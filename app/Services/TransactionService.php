<?php

namespace App\Services;

use App\Models\Arendators;
use App\Models\Bills;
use App\Models\Transactions;

class TransactionService
{
     /**
     * Создает запись в истории со счетами
     *
     * @param Bills $bill Связанный счет
     * @param Arendators $renter Инициатор транзакции
     * @param int $modification Изменение (положительное или отрицатеьлное число) в копейках
     * @param string $reason Причина (описание) транзакции
     */
    public function createRecord(Bills $bill, Arendators $renter, int $modification) {
        $transaction = new Transactions();
        $transaction->createRecord(
            $bill,
            $renter,
            $modification,
        );
    }
}