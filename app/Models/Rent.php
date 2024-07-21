<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Car;
use App\Models\Arendator;
use App\Enums\CarsStatus;
use App\Enums\RentsStatus;
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

    public function car() {
        return $this->hasOne(Car::class, 'id', 'car_id');
    }

    public function renter() {
        return $this->belongsTo(Arendator::class);
    }
}