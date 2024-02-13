<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\CarsMarks;
use App\Models\Cars;
use App\Traits\UUID;

class CarsModel extends Model
{
    use HasUuids;
    use HasFactory;
    use UUID;

    protected $fillable = [
        'mark_id',
        'name',
    ];
    public function car_mark() {
        return $this -> belongsTo(CarsMarks::class);
    }

    public function cars() {
        return $this -> hasMany(Cars::class, 'cars_models_id', 'id');
    }
}
