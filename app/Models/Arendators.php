<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bills;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arendators extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;
    protected $fillable = [
        'id',
        'default_bill_id',
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
        return $this->belongsToMany(Bills::class, 'arendatorsbills', 'arendator_id', 'bill_id');
    }

    /**
     * Изменяет поле 'default_bill_id'
     *
     * @return void
     */
    public function setDefaultBill($bill) {
        $this->default_bill_id = $bill;
    }
}
