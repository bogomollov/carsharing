<?php

namespace App\Services;
use App\Models\Cars;

class CarService
{
    /**
     * Получает статус пользователя
     *
     * @param Cars $vehicle
     * @return string
     */
    public function getStatus(Cars $vehicle) : string {
        return $vehicle->status;
    }

    /**
     * Проверяет имеет ли ТС статус(ы)
     * (Будет удалена после того как удостоверюсь что ничто не сломается)
     *
     * @param \App\Models\Cars $vehicle
     * @param array $statuses
     * @return bool
     */
    public function checkIsStatus(Cars $vehicle, array $statuses) : bool {
        if (in_array($this->getStatus($vehicle), $statuses)) {
            return true;
        } else {
            return false;
        }
    }
}