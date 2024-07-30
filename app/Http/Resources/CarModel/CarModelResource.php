<?php

namespace App\Http\Resources\CarModel;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'mark_id' => $this->mark_id,
            'name' => $this->name,
            'car_type' => $this->car_type,
            'fuel_type' => $this->fuel_type,
            'door_count' => $this->door_count,
            'seat_count' => $this->seat_count,
            'gear_box' => $this->gear_box,
            'drive_type' => $this->drive_type,
            'engine_power' => $this->engine_power,
            'year' => $this->year,
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        if (!$request->isMethod('DELETE')) {
            $response->header('Location', $request->getRequestUri());
        }
    }
}
