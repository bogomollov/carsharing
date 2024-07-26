<?php

namespace App\Http\Resources\Bill;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
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
            'arendators_count' => $this->arendators_count,
            'balance' => $this->when(in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH']), $this->balance),
            'type' => $this->type,
            'status' => $this->status,
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        if (!$request->isMethod('DELETE')) {
            $response->header('Location', "bill/{$this->id}");
        }
    }
}
