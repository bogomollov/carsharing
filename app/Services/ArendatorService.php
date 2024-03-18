<?php

namespace App\Services;

use App\Enums\BillsStatus;
use App\Exceptions\JsonException;
use App\Models\Arendator;
use App\Models\Bill;
use Illuminate\Http\JsonResponse;

class ArendatorService
{
    protected $billService;

    public function __construct(BillService $billService) {
        $this->billService = $billService;
    }

    /**
     * Получает статус пользователя
     *
     * @param Arendator $renter Связанный пользователь
     * @return string Статус
     */
    public function getStatus(Arendator $renter) : string {
        return $renter->status;
    }

    /**
     * Проверяет имеет ли пользователь статус(ы)
     * (Будет удалена после того как удостоверюсь что ничто не сломается)
     *
     * @param Arendator $renter Пользователь
     * @param array $statuses Массив статусов
     * @return bool
     */
    public function checkIsStatus(Arendator $renter, array $statuses) : bool {
        if (in_array($this->getStatus($renter), $statuses)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Устанавливает счет по умолчанию
     *
     * @param array $data Массив данных из запроса
     * @return JsonResponse
     */
    public function setdefaultBill(array $data) : JsonResponse {
        $renter = Arendator::find($data['renterId']);
        $bill = Bill::find($data['billId']);

        $badBillStatuses = [
            BillsStatus::Frozen,
            BillsStatus::Closed,
            BillsStatus::Blocked,
        ];

        // Проверяем что у пользователя действительно есть выбранный счет
        if (!$renter->bills()->find($bill->id)) {
            return response()->json(['error' => "Renter has not bill with id '$bill->id'"], 422);
        }

        // Проверяем что этот счет уже не выбран
        if ($renter->default_bill_id === $bill->id) {
            return response()->json(['error' => "Bill with id '$bill->id' is already the default bill"], 422);
        }

        // Проверяем статусы пользователя
        if (in_array($bill->status, $badBillStatuses)) {
            return response()->json(['error' => "Bill with status '$bill->status' cannot be selected as the default bill"], 400);
        }

        // if ($this->billService->checkIsStatus($bill, ['frozen', 'closed', 'blocked'])) {
        //     return response()->json(['error' => "Bill with status '$bill->status' cannot be selected as the default bill"], 400);
        // }

        $renter->setDefaultBill($bill->id);
        $renter->save();
        return response()->json([$renter], 200);
    }

     /**
     * Проверяет есть ли у пользователя счет по умолчанию
     *
     * @param Arendator $renter Пользователь
     * @return bool
     */
    public function checkDefaultBill(Arendator $renter) : bool {
        if ($renter->default_bill_id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Проверяет баланс у пользователя на счету по умолчанию
     * (Исправить)
     *
     * @param Arendator $renter Пользователь
     * @return mixed
     */
    public function checkBalanceOnDefaultBill(Arendator $renter) : mixed {
        if ($renter->default_bill_id) {
            return Bill::find($renter->default_bill_id)->balance;
        } else {
            return null;
        }
    }
}