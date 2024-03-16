<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CarModel extends Model
{
    use HasUuids;
    use HasFactory;

    public $incrementing = false;

    protected $table = 'carsmodels';

    protected $fillable = [
        'id',
        'mark_id',
        'name',
    ];
}
