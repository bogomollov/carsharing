<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'arendator_id' => $this->arendator_id,
            'bill_id' => $this->bill_id,
            'modification' => $this->modification,
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        if (!$request->isMethod('DELETE')) {
            $response->header('Location', $request->getRequestUri());
        }
    }
}
