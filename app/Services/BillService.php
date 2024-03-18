<?php

namespace App\Services;

use App\Models\Arendator;
use App\Models\Bill;
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
     * @param Bill $renter Пользователь для которого получаем статус
     * @return string
     */
    public function getStatus(Bill $bill) : string {
        return $bill->status;
    }

    /**
     * Проверяет имеет ли счет статус(ы).
     * (После добавления Enum'ов потребность в функции пропала. Будет удалена после того как удостоверюсь что ничто не сломается)
     *
     * @param Bill $renter Пользователь для которого проверяем наличие статуса(ов)
     * @param array $statuses Массив со статусами
     * @return bool
     */
    public function checkIsStatus(Bill $bill, array $statuses) : bool {
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
    public function setBillStatus(Bill $bill, array $data) : JsonResponse {
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
     * @param Bill $bill Связанный счет
     * @param Arendator $renter Инициатор изменения
     * @param int $modification Изменение (положительное или отрицатеьлное число) в копейках
     * @param string $reason Причина изменения
     */
    public function modificateBalance(Bill $bill, Arendator $renter, int $modification) {
        $bill->modificateBalance($modification);
        $this->transactionService->createRecord($bill, $renter, $modification);
    }
}