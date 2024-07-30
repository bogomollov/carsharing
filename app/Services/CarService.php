<?php

namespace App\Services;

use App\Enums\CarsStatus;
use App\Http\Resources\Car\CarResource;
use App\Models\Car;

class CarService
{
    public function getStatus(Car $car) : string {
        return $car->status;
    }

    public function setStatus(Car $car, $status) {      
        if ($this->getStatus($car) == $status) {
            return response()->json([
                'status' => 422,
                'message' => "Car already has '$status' status"
            ], 422);
        }
        elseif ($status == CarsStatus::Expectation) {
            $car->status = CarsStatus::Expectation;
            $car->update();
            $car->delete();
        }
        else {
            $car->status = $status;
            $car->update();
        }
        return new CarResource($car);
    }

    public function checkIsStatus(Car $vehicle, array $statuses) : bool {
        if (in_array($this->getStatus($vehicle), $statuses)) {
            return true;
        } else {
            return false;
        }
    }
}