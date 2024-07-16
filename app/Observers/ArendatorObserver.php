<?php

namespace App\Observers;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache as Redis;
use App\Models\Arendator;

class ArendatorObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Arendators "created" event.
     */
    public function created(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
    }

    /**
     * Handle the Arendators "saved" event.
     */
    public function saved(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
    }

    /**
     * Handle the Arendators "updated" event.
     */
    public function updated(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
    }

    /**
     * Handle the Arendators "deleted" event.
     */
    public function deleted(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
    }

    /**
     * Handle the Arendators "deleting" event.
     */
    public function deleting(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
    }

    /**
     * Handle the Cars "retrieved" event.
     */
    public function retrieved(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
    }

    /**
     * Handle the Arendators "restored" event.
     */
    public function restored(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
    }

    public function forceDeleted(Arendator $arendator): void
    {
        Redis::forget('arendator_index');
    }
}
