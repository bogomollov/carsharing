<?php

namespace App\Services;

use App\Http\Resources\Bill\BillResource;
use App\Models\Bill;
use Illuminate\Http\JsonResponse;

class BillService
{
    public function getStatus(Bill $bill) : string {
        return $bill->status;
    }

    public function setBillStatus($id, $status) : JsonResponse {
        $bill = Bill::find($id);

        if ($this->getStatus($bill) === $status) {
            return response()->json(['error' => "Bill already has '$status' status"], 422);
        }
        else {
            $bill->status = $status;
            $bill->update();
            return new BillResource($bill);
        }
    }

    public function modificateBalance($id, float $modification) {
        $bill = Bill::find($id);
        $bill->balance += $modification;
        $bill->update();
    }
}