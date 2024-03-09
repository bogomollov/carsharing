<?php

namespace App\Services;

use App\Enums\RentsStatus;
use App\Enums\ArendatorsStatus;
use App\Enums\CarsStatus;
use App\Models\Bills;
use App\Models\Rents;
use App\Models\Arendators;
use App\Models\Cars;
use Illuminate\Http\JsonResponse;

class RentService
{
    protected $renterService;
    protected $vehicleService;
    protected $billService;
    protected $transactionService;

    public function __construct(ArendatorService $renterService, CarService $vehicleService, BillService $billService, TransactionService $transactionService) {
        $this->renterService = $renterService;
        $this->vehicleService = $vehicleService;
        $this->billService = $billService;
        $this->transactionService = $transactionService;
    }

    /**
     * Получает статус пользователя
     *
     * @param Arendators $renter Пользователь
     * @return string
     */
    public function getStatus(Arendators $rent) : string {
        return $rent->status;
    }

    /**
     * Получает статус пользователя
     * (После добавления Enum'ов потребность в функции пропала. Будет удалена после того как удостоверюсь что ничто не сломается)
     *
     * @param Arendators $renter Пользователь
     * @param array $statuses Статус(ы) для поиска
     * @return string
     */
    public function checkIsStatus(Arendators $rent, array $statuses) : bool {
        if (in_array($this->getStatus($rent), $statuses)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Открывает аренду
     *
     * @param array $data
     * @return JsonResponce
     */
    public function open(array $data) : JsonResponse {
        $renter = Arendators::find($data['renterId']);
        $vehicle = Cars::find($data['vehicleId']);

        $badRenterStatuses = array(
            ArendatorsStatus::Frozen,
            ArendatorsStatus::Blocked,
        );

        if (in_array($renter->status, $badRenterStatuses)) {
            return response()->json(["error" => "Renter with id '$renter->id' has '$renter->status' status"], 403);
        }

        if (!in_array($vehicle->status, [CarsStatus::Expectation])) {
            return response()->json(["error" => "Vehicle with id '$vehicle->id' can not be rented"], 403);
        }

        if (!$this->renterService->checkDefaultBill($renter)) {
            return response()->json(["error" => "Renter does not have default bill account"], 403);
        }

        if ($this->renterService->checkBalanceOnDefaultBill($renter) < 100000) {
            return response()->json(["error" => "Renter does not have enough money in the main bill account"], 403);
        }

        $rent = new Arendators;
        $rent->open($renter->id, $vehicle->id);

        return response()->json($rent, 200);
    }

    /**
     * Закрывает аренду
     *
     * @param array $data
     * @return JsonResponce
     */
    public function close(array $data) : JsonResponse {
        $rent = Rents::find($data['rentId']);
        $renter = Arendators::find($rent->renter_id);
        $vehicle = Cars::find($rent->vehicle_id);

        if (!in_array($rent->status, [RentsStatus::Open])) {
            return response()->json(["error" => "Rent status in not open"], 403);
        }

        if (!in_array($vehicle->status, [CarsStatus::Rented])) {
            return response()->json(["error" => "Vehicle status is not rented"], 403);
        }

        if (!$this->renterService->checkDefaultBill($renter)) {
            return response()->json(['error' => "Renter with id '$renter->id' dont have default bill"], 400);
        } else {
            $bill = Bills::find($renter->default_bill_id);
        }

        // Закрываем аренду
        $rent->close();

        // Высчитываем цену по которую необходимо вычесть со счета
        $total_price = $rent->total_price;

        // Модифицируем баланс
        $this->billService->modificateBalance($bill, $renter, -$total_price);

        return response()->json($rent, 200);
    }
}