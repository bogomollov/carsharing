<?php

namespace App\Services;

use App\Enums\BillsStatus;
use App\Enums\BillsType;
use App\Http\Resources\Bill\BillResource;
use App\Models\Bill;

class BillService
{
    public function getStatus(Bill $bill) : string {
        return $bill->status;
    }

    public function setStatus(Bill $bill, $status) {
        if ($this->getStatus($bill) == $status) {
            return response()->json([
                'status' => 422,
                'message' => "Bill already has '$status' status"
            ], 422);
        }
        elseif ($status == BillsStatus::Closed) {
            $bill->status = BillsStatus::Closed;
            $bill->update();
            $bill->delete();
        }
        else {
            $bill->status = $status;
            $bill->update();
        }
        return new BillResource($bill);
    }

    public function updateArendatorsCount($id) {
        $bill = Bill::find($id);
        $bill->arendators_count = $bill->bills->count();
        $bill->update();
    }

    public function updateBillType($id) {
        $bill = Bill::find($id);

        if ($bill->arendators_count > 1)
        {
            $bill->type = BillsType::Corporated;
            $bill->update();
        }
        elseif ($bill->arendators_count == 1)
        {
            $bill->type = BillsType::Personal;
            $bill->update();
        }
        elseif ($bill->arendators_count == 0) {
            $bill->status = BillsStatus::Blocked;
            $bill->update();
        }
        return new BillResource($bill);
    }

    public function modificateBalance($bill, float $modification) {
        $bill->balance += $modification;
        $bill->update();
    }
}