<?php

namespace App\Models;

use App\Enums\ArendatorsStatus;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arendator extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'default_bill_id',
        'last_name',
        'first_name',
        'middle_name',
        'status',
        'passport_series',
        'passport_number',
        'phone',
    ];

    protected $hidden = ['passport_series', 'passport_number'];

    protected function casts(): array
    {
        return [
            'status' => ArendatorsStatus::class,
        ];
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function bill() {
        return $this->belongsTo(Bill::class, 'default_bill_id', 'id');
    }

    public function arendator() {
        return $this->belongsTo(Rent::class, 'id', 'arendator_id');
    }
}
