<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;

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
