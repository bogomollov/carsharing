<?php

namespace App\Services;

use App\Enums\RentsStatus;
use App\Enums\ArendatorsStatus;
use App\Enums\CarsStatus;
use App\Http\Resources\Rent\RentResource;
use App\Models\Bill;
use App\Models\Rent;
use App\Models\Arendator;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use App\Services\ArendatorService;
use App\Services\CarService;
use App\Services\BillService;
use Carbon\Carbon;

class RentService
{
    protected $arendatorService;
    protected $carService;
    protected $billService;
    protected $transactionService;

    public function __construct(ArendatorService $arendatorService, CarService $carService, BillService $billService, TransactionService $transactionService) {
        $this->arendatorService = $arendatorService;
        $this->carService = $carService;
        $this->billService = $billService;
        $this->transactionService = $transactionService;
    }

    public function getStatus(Rent $rent) : string {
        return $rent->status;
    }

    public function open($id, $id2) {
        $arendator = Arendator::find($id);
        $car = Car::find($id2);

        if ($arendator->status != ArendatorsStatus::Active) {
            return response()->json([
                'status' => 403,
                'message' => "Renter with id '$arendator->id' has '$arendator->status' status"
            ], 403);
        }
        elseif ($car->status != CarsStatus::Expectation) {
            return response()->json([
                'status' => 403,
                'message' => "Car with id '$car->id' can not be rented"
            ], 403);
        }
        elseif (!$this->arendatorService->checkDefaultBill($arendator)) {
            return response()->json([
                'status' => 403,
                'message' => "Renter does not have default bill account"
            ], 403);
        }
        elseif ($this->arendatorService->checkBalanceOnDefaultBill($arendator) < 1) {
            return response()->json([
                'status' => 403,
                'message' => "Renter does not have enough money in the main bill account"
            ], 403);
        }
        else {
            $rent = Rent::create([
                'car_id' => $car->id,
                'arendator_id' => $arendator->id,
                'status' => RentsStatus::Open,
                'start_datetime' => Carbon::now(),
            ]);
            $rent->save();
            $car->status = CarsStatus::Rented;
            $car->update();

            return new RentResource($rent);
        }
    }

    public function close(Rent $rent) {
        $car = Car::find($rent->car_id);
        $arendator = Arendator::find($rent->arendator_id);
        $bill = Bill::find($arendator->default_bill_id);

        if ($rent->status != RentsStatus::Open) {
            return response()->json([
                'status' => 403,
                'message' => "Rent status in not open"
            ], 403);
        }
        elseif ($car->status != CarsStatus::Rented) {
            return response()->json([
                'status' => 403,
                'message' => "Car status is not rented"
            ], 403);
        }
        elseif (!$this->arendatorService->checkDefaultBill($arendator)) {
            return response()->json([
                'status' => 400,
                'message' => "Renter with id '$arendator->id' dont have default bill"
            ], 400);
        }
        else {
            $rent->status = RentsStatus::Closed;
            $rent->end_datetime = Carbon::now();
            $rent->update();
    
            $car->status = CarsStatus::Expectation;
            $car->update();
    
            $this->calculateRentedTime($rent);
            $this->calculateTotalPrice($rent, $car);

            $this->transactionService->createTransaction($arendator, $bill, $rent->total_price);
            $this->billService->modificateBalance($bill, -$rent->total_price);
            return new RentResource($rent);
        }
    }

    public function calculateRentedTime(Rent $rent) {
        $rent->rented_time = $rent->end_datetime->diffInMinutes($rent->start_datetime);
        $rent->update();
    }

    public function calculateTotalPrice(Rent $rent, Car $car) {
        $res = $car->price_minute * $rent->rented_time;
        $rent->total_price = $res;
        $rent->update();
    }
}