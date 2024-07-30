<?php

namespace App\Http\Resources\Arendator;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ArendatorResource extends JsonResource
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
            'default_bill_id' => $this->default_bill_id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'status' => $this->status,
            'passport_series' => $this->when(in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH']), $this->passport_series),
            'passport_number' => $this->when(in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH']), $this->passport_number),
            'phone' => $this->phone,
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        if (!$request->isMethod('DELETE')) {
            $response->header('Location', $request->getRequestUri());
        }
    }
}
