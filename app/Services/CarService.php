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
        if (!in_array($status, CarsStatus::getValues())) {
            return response()->json(['error' => "This status cannot be applied"], 404);
        }
        elseif ($this->getStatus($car) == $status) {
            return response()->json(['error' => "Car already has '$status' status"], 422);
        }
        else {
            $car->status = $status;
            $car->update();
            return new CarResource($car);
        }       
    }

    public function checkIsStatus(Car $vehicle, array $statuses) : bool {
        if (in_array($this->getStatus($vehicle), $statuses)) {
            return true;
        } else {
            return false;
        }
    }
}