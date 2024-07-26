<?php

namespace App\Models;

use App\Enums\BillsStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Arendator;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'arendators_count',
        'balance',
        'type',
        'status',
    ];

    protected $hidden = [
       'balance',
    ];

    protected function casts(): array
    {
        return [
            'status' => BillsStatus::class,
        ];
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function bills() {
        return $this->hasMany(Arendator::class, 'default_bill_id');
    }

    public function transactions() {
        return $this->belongsTo(Transaction::class, 'id', 'bill_id');
    }
}
