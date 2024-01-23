<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class Cars extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'model_id',
        'status',
        'mileage',
        'location',
        'price_minute'
    ];
}
