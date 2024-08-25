<?php

namespace App\Models;

use App\Enums\ArendatorsStatus;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Arendator extends Authenticatable implements JWTSubject
{
    use HasUuids, HasFactory, SoftDeletes, HasApiTokens, Notifiable;

    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'email',
        'password',
        'default_bill_id',
        'last_name',
        'first_name',
        'middle_name',
        'status',
        'passport_series',
        'passport_number',
        'driverlicense_series',
        'driverlicense_number',
        'driverlicense_date',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'passport_series',
        'passport_number',
    ];

    protected $casts = [
        'status' => ArendatorsStatus::class,
        'password' => 'hashed',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function bill() {
        return $this->belongsTo(Bill::class, 'default_bill_id', 'id');
    }

    public function arendator() {
        return $this->belongsTo(Rent::class, 'id', 'arendator_id');
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims() {
        return [];
    }
}
