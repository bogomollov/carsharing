<?php

namespace App\Models;

use App\Enums\CarsType;
use App\Enums\DrivesType;
use App\Enums\FuelsType;
use App\Enums\GearBoxesType;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarModel extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'carsmodels';

    protected $fillable = [
        'id',
        'mark_id',
        'name',
        'car_type',
        'fuel_type',
        'door_count',
        'seat_count',
        'gear_box',
        'engine_power',
    ];

    protected $casts = [
        'car_type' => CarsType::class,
        'fuel_type' => FuelsType::class,
        'gear_box' => GearBoxesType::class,
        'drive_type' => DrivesType::class,
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
