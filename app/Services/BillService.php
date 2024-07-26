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

    public function setBillStatus(Bill $bill, $status) {
        if ($this->getStatus($bill) === $status) {
            return response()->json([
                'status' => 422,
                'message' => "Bill already has '$status' status"
            ], 422);
        }
        else {
            $bill->status = $status;
            $bill->update();
            return new BillResource($bill);
        }
    }

    public function updateArendatorsCount($id) {
        $bill = Bill::find($id);
        $bill->arendators_count = $bill->bills->count();
        $bill->update();
    }

    public function updateBillType($id, $type) {
        $bill = Bill::find($id);

        if ($bill->type == $type) {
            return response()->json(["error" => "This status is already set"], 422);
        }
        elseif ($bill->arendators_count > 1)
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

    public function modificateBalance($id, float $modification) {
        $bill = Bill::find($id);
        $bill->balance += $modification;
        $bill->update();
    }
}