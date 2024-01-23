<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Arendators extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'bill_id',
        'last_name',
        'first_name',
        'middle_name',
        'status',
        'passport_series',
        'passport_number',
        'phone'
    ];

    protected $hidden = [
        'passport_series',
        'passport_number',
        'phone',
    ];

    public function bills()
    {
        return $this->belongsToMany(Bill::class, 'bill_renter', 'arendator_id', 'bill_id');
    }

    protected static function boot()
    {
        parent::boot();

        // При сохранении в модель
        static::saving(function ($renter) {
        });
    }

    /**
     * Изменяет поле 'default_bill'
     *
     * @return void
     */
    public function setDefaultBill($billId) {
        $this->default_bill = $billId;
    }
}
