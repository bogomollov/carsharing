<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarMark extends Model
{
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'carsmarks';

    protected $fillable = [
        'id',
        'manufacturer_id',
        'name'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
