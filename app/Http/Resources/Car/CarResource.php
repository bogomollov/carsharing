<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'model_id' => $this->model_id,
            'status' => $this->status,
            'mileage' => $this->mileage,
            'license_plate' => $this->license_plate,
            'year' => $this->year,
            'location' => $this->location,
            'price_minute' => $this->price_minute,
        ];
    }
}
