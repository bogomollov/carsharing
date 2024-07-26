<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bill;
use App\Models\Arendator;
use DateTimeInterface;
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

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function bill() {
        return $this->hasMany(Bill::class, 'id', 'bill_id');
    }

    public function arendator() {
        return $this->hasMany(Arendator::class, 'id', 'arendator_id');
    }
}
