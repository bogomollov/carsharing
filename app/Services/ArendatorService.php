<?php

namespace App\Services;

use App\Enums\ArendatorsStatus;
use App\Enums\BillsStatus;
use App\Http\Resources\Arendator\ArendatorResource;
use App\Models\Arendator;
use App\Models\Bill;

class ArendatorService
{
    public function getStatus(Arendator $arendator) : string {
        return $arendator->status;
    }

    public function setStatus(Arendator $arendator, $status) {
        if ($this->getStatus($arendator) == $status) {
            return response()->json([
                'status' => 422,
                'message' => "Arendator already has '$status' status"
            ], 422);
        }
        elseif ($status == ArendatorsStatus::Deleted) {
            $arendator->status = ArendatorsStatus::Deleted;
            $arendator->update();
            $arendator->delete();
        }
        else {
            $arendator->status = $status;
            $arendator->update();
        }
        return new ArendatorResource($arendator);
    }

    public function setDefaultBill(Arendator $arendator, $bill_id) {
        $bill = Bill::find($bill_id);
        $badBillStatuses = [
            BillsStatus::Frozen,
            BillsStatus::Closed,
            BillsStatus::Blocked,
        ];

        if ($arendator->default_bill_id === $bill_id) {
            return response()->json([
                'status' => 422,
                'message' => "Bill with id '$bill_id' is already the default bill"
            ], 422);
        }
        elseif (in_array($bill->status, $badBillStatuses)) {
            return response()->json([
                'status' => 400,
                'message' => "Bill with status '$bill->status' cannot be selected as the default bill"
            ], 400);
        }
        else {
            $arendator->default_bill_id = $bill_id;
            $arendator->update();
            return new ArendatorResource($arendator);
        }
    }

    public function checkDefaultBill(Arendator $arendator) : bool {
        if ($arendator->default_bill_id) {
            return true;
        } else {
            return false;
        }
    }

    public function checkBalanceOnDefaultBill(Arendator $arendator) : mixed {
        if ($arendator->default_bill_id) {
            return Bill::find($arendator->default_bill_id)->balance;
        } else {
            return null;
        }
    }
}