<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CarsMarks extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'id',
        'manufacturer_id',
        'name'
    ];
}
