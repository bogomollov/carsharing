<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Car;
use App\Models\Arendator;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rent extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'car_id',
        'arendator_id',
        'status',
        'start_datetime',
        'end_datetime',
        'rented_time',
        'total_price',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function car() {
        return $this->hasOne(Car::class, 'id', 'car_id');
    }

    public function renter() {
        return $this->hasOne(Arendator::class, 'id', 'arendator_id');
    }
}