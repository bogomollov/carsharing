<?php

namespace App\Http\Resources\Cars;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarsResource extends JsonResource
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
            'prod' => $this->prod,
            'mark' => $this->mark,
            'model' => $this->model,
            'year' => $this->year,
        ];
    }
}
