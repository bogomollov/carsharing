<?php

namespace App\Models;

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
        'year',
        'location',
        'price_minute',
    ];
}
