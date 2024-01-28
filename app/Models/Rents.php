<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Enums\CarsStatus;
use App\Enums\RentsStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rents extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'car_id',
        'arendator_id',
        'status',
        'start_datetime',
        'end_datetime',
        'rented_time',
        'price',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($rent) {
            // Если существует дата закрытия аренды, то необходимо посчитать время и стоимость
            if ( $rent->end_datetime != null ) {
                $rent->calculateRentedTime();
                $rent->calculateTotalPrice();
            }
        });
    }

    // Вынести в сервис
    public function calculateRentedTime() {
        if ($this->end_datetime != null) {
            $end_datetime = new Carbon($this->end_datetime);
            $start_datetime = new Carbon($this->start_datetime);
            $this->rented_time = $end_datetime->diffInMinutes($start_datetime);
        }
    }

    // Вынести в сервис
    public function calculateTotalPrice() {
        if ( $this->rented_time ) {
            $this->total_price = $this->vehicle->price_at_minute * $this->rented_time;
        }
    }

    /**
     * Открывает аренду
     *
     * @return void
     */
    public function close() {
        $this->end_datetime = Carbon::now();
        $this->calculateRentedTime();
        $this->calculateTotalPrice();
        $this->status = RentsStatus::Closed;
        $this->vehicle->status = CarsStatus::Expectation;

        $this->vehicle->update();
        $this->update();
    }

    /**
     * Закрывает аренду
     *
     * @return void
     */
    public function open($renterId, $vehicleId) {
        $this->vehicle_id = $vehicleId;
        $this->renter_id = $renterId;
        $this->start_datetime = Carbon::now();

        $this->vehicle->status = CarsStatus::Rented;

        $this->vehicle->save();
        $this->save();
    }
}
