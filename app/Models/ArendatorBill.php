<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArendatorBill extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'arendatorsbills';

    protected $fillable = [
        'id',
        'arendator_id',
        'bill_id',
    ];

    public function bill() {
        return $this->belongsTo(Bill::class);
    }
    public function arendator() {
        return $this->belongsTo(Arendator::class);
    }

    protected static function boot() {
        parent::boot();

        static::saving(function ($bill) {
            if ($bill->arendator->default_bill_id == null) {
                $bill->arendator->default_bill_id = $bill->id;
                $bill->arendator->save();
            }
        });

        static::saved(function ($bill) {
            $bill->bill_id->updateArendatorsCount();
            $bill->bill_id->updateBillsType();
        });

        static::deleted(function ($bill) {
            $bill->bill_id->updateArendatorsCount();
            $bill->bill_id->updateBillsType();

            if ($bill->arendator->default_bill_id == $bill->id) {
                $bill->arendator->default_bill_id = null;
                $bill->arendator->save();
            }
        });
    }
}
