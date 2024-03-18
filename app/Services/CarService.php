<?php

namespace App\Services;
use App\Models\Car;

class CarService
{
    /**
     * Получает статус пользователя
     *
     * @param Car $vehicle
     * @return string
     */
    public function getStatus(Car $vehicle) : string {
        return $vehicle->status;
    }

    /**
     * Проверяет имеет ли ТС статус(ы)
     * (Будет удалена после того как удостоверюсь что ничто не сломается)
     *
     * @param \App\Models\Car $vehicle
     * @param array $statuses
     * @return bool
     */
    public function checkIsStatus(Car $vehicle, array $statuses) : bool {
        if (in_array($this->getStatus($vehicle), $statuses)) {
            return true;
        } else {
            return false;
        }
    }
}