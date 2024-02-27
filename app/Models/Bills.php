<?php

namespace App\Models;

use App\Enums\BillsStatus;
use App\Enums\BillsType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Arendators;

class Bills extends Model
{
    use HasFactory;

    protected $fillable = [
        'arendator_id',
        'bill_id',
        'balance',
        'status',
        'type'
    ];

    protected $hidden = [
        'balance'
    ];

    public function renters()
    {
        return $this->belongsToMany(Arendators::class, 'arendatorsbills', 'bill_id', 'arendator_id');
    }

    public function updateRentersCount() {
        $this->arendators_count = $this->renters()->count();
        $this->save();
    }

    public function updateBillType() {
        if ($this->renters_count > 1)
        {
            $this->type = BillsType::Corporated;
        }

        elseif ($this->renters_count == 1)
        {
            $this->type = BillsType::Personal;
        }

        elseif ($this->renters_count == 0) {
            $this->status = BillsStatus::Blocked;
        }

        $this->save();
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function modificateBalance($modification) {
        $this->balance += $modification;
        $this->save();
    }
}
