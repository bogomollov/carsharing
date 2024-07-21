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

    public function __construct(ArendatorService $arendatorService, CarService $carService, BillService $billService) {
        $this->arendatorService = $arendatorService;
        $this->carService = $carService;
        $this->billService = $billService;
    }

    public function getStatus(Rent $rent) : string {
        return $rent->status;
    }

    public function open($id, $id2) : JsonResponse {
        $arendator = Arendator::find($id);
        $car = Car::find($id2);

        $badRenterStatuses = array(ArendatorsStatus::Frozen, ArendatorsStatus::Blocked,);

        if (in_array($arendator->status, $badRenterStatuses)) {
            return response()->json(["error" => "Renter with id '$arendator->id' has '$arendator->status' status"], 403);
        }
        if (!in_array($car->status, [CarsStatus::Expectation])) {
            return response()->json(["error" => "Car with id '$car->id' can not be rented"], 403);
        }
        if (!$this->arendatorService->checkDefaultBill($arendator)) {
            return response()->json(["error" => "Renter does not have default bill account"], 403);
        }
        if ($this->arendatorService->checkBalanceOnDefaultBill($arendator) < 1) {
            return response()->json(["error" => "Renter does not have enough money in the main bill account"], 403);
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
            $car->save();

            return new RentResource($rent);
        }
    }

    public function close($id) : JsonResponse {

        $rent = Rent::find($id);
        $arendator = Arendator::find($rent->arendator_id);
        $car = Car::find($rent->car_id);

        if (!in_array($rent->status, [RentsStatus::Open])) {
            return response()->json(["error" => "Rent status in not open"], 403);
        }

        if (!in_array($car->status, [CarsStatus::Rented])) {
            return response()->json(["error" => "Vehicle status is not rented"], 403);
        }

        if (!$this->arendatorService->checkDefaultBill($arendator)) {
            return response()->json(['error' => "Renter with id '$arendator->id' dont have default bill"], 400);
        }
        else {
            $rent->status = RentsStatus::Closed;
            $rent->end_datetime = Carbon::now();
            $rent->update();
    
            $car->status = CarsStatus::Expectation;
            $car->update();
    
            $this->calculateRentedTime($rent);
            $this->calculateTotalPrice($rent, $car);
            $this->billService->modificateBalance(Bill::find($arendator->default_bill_id), -$rent->total_price);

            $rent->delete();
            return new RentResource($rent);
        }      
    }

    public function calculateRentedTime($rent) {
        $rent->rented_time = $rent->end_datetime->diffInMinutes($rent->start_datetime);
        $rent->update();
    }

    public function calculateTotalPrice($rent, $car) {
        $res = $car->price_minute * $rent->rented_time;
        $rent->total_price = $res;
        $rent->update();
    }
}