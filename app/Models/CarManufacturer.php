<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CarManufacturer extends Model
{
    use HasFactory;
    use HasUuids;
    
    public $incrementing = false;

    protected $table = 'carsmanufacturers';

    protected $fillable = [
        'id',
        'name',
    ];
}
