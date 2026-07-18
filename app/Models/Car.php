<?php

namespace App\Models;

use App\Enums\CarsStatus;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    
    public $incrementing = false;

    protected $fillable = [
        'id',
        'model_id',
        'status',
        'mileage',
        'license_plate',
        'vin',
        'location',
        'price_minute',
    ];

    protected $hidden = [
        'location',
    ];

    protected $casts = [
        'status' => CarsStatus::class,
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function car() {
        return $this->belongsTo(Rent::class, 'id', 'car_id');
    }

    public function getLatitudeAttribute(): float
    {
        return (float) explode(' ', $this->location)[0];
    }

    public function getLongitudeAttribute(): float
    {
        return (float) explode(' ', $this->location)[1];
    }

    public function setCoordinates(float $latitude, float $longitude): void
    {
        $this->location = "{$latitude} {$longitude}";
    }
}
