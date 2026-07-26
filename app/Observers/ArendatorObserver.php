<?php

namespace App\Observers;

use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache as Redis;
use App\Models\Arendator;
use App\Services\BillService;

class ArendatorObserver implements ShouldHandleEventsAfterCommit
{
    
    public function created(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
        $billService = new BillService();
        $billService->updateArendatorsCount($arendator->default_bill_id);
        $billService->updateBillType($arendator->default_bill_id);
    }

    
    public function saved(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
    }

    
    public function updated(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
        Redis::forget($arendator->id);
        $billService = new BillService();
        $billService->updateArendatorsCount($arendator->default_bill_id);
        $billService->updateBillType($arendator->default_bill_id);
    }

    
    public function deleted(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
        Redis::forget($arendator->id);
        $billService = new BillService();
        $billService->updateArendatorsCount($arendator->default_bill_id);
        $billService->updateBillType($arendator->default_bill_id);
    }

    
    public function deleting(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
    }

    
    public function restored(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
        $billService = new BillService();
        $billService->updateArendatorsCount($arendator->default_bill_id);
        $billService->updateBillType($arendator->default_bill_id);
    }

    public function forceDeleted(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
        $billService = new BillService();
        $billService->updateArendatorsCount($arendator->default_bill_id);
        $billService->updateBillType($arendator->default_bill_id);
    }
}
