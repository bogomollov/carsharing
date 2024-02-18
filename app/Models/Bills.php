<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use App\Models\Arendators;

class Bills extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        'id',
        'arendator_id',
        'bill_id',
        'balance',
        'status'
    ];

    protected $hidden = [
        'balance'
    ];

    public function arendator_id() {
        return $this->hasMany(Arendators::class, 'arendator_id', 'id');
    }

}
