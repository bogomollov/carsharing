<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CarMark extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false;

    protected $table = 'carsmarks';

    protected $fillable = [
        'id',
        'manufacturer_id',
        'name'
    ];
}
