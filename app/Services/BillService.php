<?php

namespace App\Services;

use App\Models\Arendators;
use App\Models\Bills;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

class BillService
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    /**
     * Получает статус счета
     *
     * @param Bills $renter Пользователь для которого получаем статус
     * @return string
     */
    public function getStatus(Bills $bill) : string {
        return $bill->status;
    }

    /**
     * Проверяет имеет ли счет статус(ы).
     * (После добавления Enum'ов потребность в функции пропала. Будет удалена после того как удостоверюсь что ничто не сломается)
     *
     * @param Bills $renter Пользователь для которого проверяем наличие статуса(ов)
     * @param array $statuses Массив со статусами
     * @return bool
     */
    public function checkIsStatus(Bills $bill, array $statuses) : bool {
        if (in_array($this->getStatus($bill), $statuses)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Меняет статус счета
     *
     * @param array $data
     * @return JsonReaponse
     */
    public function setBillStatus(Bills $bill, array $data) : JsonResponse {
        $status = $data['status'];

        if ($this->getStatus($bill) === $status) {
            return response()->json(['error' => "Bill already has '$status' status"], 422);
        }

        $bill->setStatus( $status );
        $bill->save();
        return response()->json([$bill], 200);
    }

     /**
     * Изменяет баланс счета
     *
     * @param Bills $bill Связанный счет
     * @param Arendators $renter Инициатор изменения
     * @param int $modification Изменение (положительное или отрицатеьлное число) в копейках
     * @param string $reason Причина изменения
     */
    public function modificateBalance(Bills $bill, Arendators $renter, int $modification) {
        $bill->modificateBalance($modification);
        $this->transactionService->createRecord($bill, $renter, $modification);
    }
}