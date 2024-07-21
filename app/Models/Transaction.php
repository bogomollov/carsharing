<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bill;
use App\Models\Arendator;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'arendator_id',
        'bill_id',
        'modification',
    ];

    public function bill() {
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    public function arendator() {
        return $this->belongsTo(Arendator::class, 'arendator_id');
    }

    public function updateBalance() {
        $this->bill->balance += $this->modification;
        $this->bill->save();
    }
}
