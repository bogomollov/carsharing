<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array
    {
        return [
            'id' => $this->id,
            'model_id' => $this->model_id,
            'status' => $this->status,
            'mileage' => $this->mileage,
            'license_plate' => $this->license_plate,
            'location' => $this->when(in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH']), $this->location),
            'price_minute' => $this->price_minute,
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        if (!$request->isMethod('DELETE')) {
            $response->header('Location', $request->getRequestUri());
        }
    }
}
