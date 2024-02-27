<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bills;

class Arendators extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'bill_id',
        'passport_series',
        'passport_number',
        'phone',
    ];

    public function bills()
    {
        return $this->belongsToMany(Bills::class, 'arendatorsbills', 'arendator_id', 'bill_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($renter) {
        });
    }

    /**
     * Изменяет поле 'default_bill_id'
     *
     * @return void
     */
    public function setDefaultBill($billId) {
        $this->default_bill_id = $billId;
    }
}
