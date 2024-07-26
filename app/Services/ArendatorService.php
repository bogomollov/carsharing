<?php

namespace App\Services;

use App\Enums\BillsStatus;
use App\Http\Resources\Arendator\ArendatorResource;
use App\Models\Arendator;
use App\Models\Bill;
use Illuminate\Http\JsonResponse;
use App\Services\BillService;

class ArendatorService
{
    protected $billService;

    public function __construct(BillService $billService) {
        $this->billService = $billService;
    }

    public function getStatus($id) : string {
        return Arendator::find($id)->status;
    }

    public function setStatus(Arendator $arendator, $status) {
        if ($arendator->status == $status) {
            return response()->json(['error' => "User already has this status"], 422);
        }
        if ($status == 'deleted') {
            $arendator->status = $status;
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

        if (!$bill) {
            return response()->json(['error' => "No such payment account exists"], 404);
        }
        if ($arendator->default_bill_id === $bill_id) {
            return response()->json(['error' => "Bill with id '$bill' is already the default bill"], 422);
        }
        if (in_array($bill->status, $badBillStatuses)) {
            return response()->json(['error' => "Bill with status '$bill->status' cannot be selected as the default bill"], 400);
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