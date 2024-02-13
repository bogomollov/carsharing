<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class CarsMarks extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        'manufacturer_id',
        'name'
    ];
}
