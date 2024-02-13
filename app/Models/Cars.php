<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Cars extends Model
{
    use HasFactory;
    use UUID;
    
    protected $fillable = [
        'id',
        'model_id',
        'status',
        'mileage',
        'location',
        'price_minute'
    ];
}
