<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

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
}
