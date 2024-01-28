<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bills;
use App\Models\Arendators;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Transactions extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bill_id',
        'arendator_id',
        'datetime',
    ];

    /**
     * Создает запись в истории операций
     * 
     * @param Bill $bill
     * @param Renter $renter
     */
    public function createRecord(Bills $bill, Arendators $arendator_id) {
        $this->bill_id = $bill->id;
        $this->arendator_id = $arendator_id->id;
        $this->datetime = Carbon::now();

        $this->save();
    }
}
