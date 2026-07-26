<?php

namespace App\Http\Resources\CarMark;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarMarkResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        if (!$request->isMethod('DELETE')) {
            $response->header('Location', $request->getRequestUri());
        }
    }
}
