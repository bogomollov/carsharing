<?php

namespace App\Http\Resources\Arendator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArendatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'default_bill_id' => $this->default_bill_id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'status' => $this->status,
            'passport_series' => $this->passport_series,
            'passport_number' => $this->passport_number,
            'phone' => $this->phone,
        ];
    }
}
