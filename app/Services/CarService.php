<?php

namespace App\Services;
use App\Models\Car;

class CarService
{
    public function getStatus(Car $vehicle) : string {
        return $vehicle->status;
    }

    public function checkIsStatus(Car $vehicle, array $statuses) : bool {
        if (in_array($this->getStatus($vehicle), $statuses)) {
            return true;
        } else {
            return false;
        }
    }
}