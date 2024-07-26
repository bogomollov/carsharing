<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\CarsStatus;
use App\Enums\RentsStatus;
use App\Models\Arendator;
use App\Models\Car;
use App\Models\Rent;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory>
 */
class RentFactory extends Factory
{
    protected $model = Rent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $beginDateTime = fake()->dateTimeBetween('-365 days','now',null);
        $endDateTime = fake()->dateTimeInInterval($beginDateTime,'+1 days',null);
        
        return [
            'id' => fake()->uuid(),
            'car_id' => Car::factory(),
            'arendator_id' => Arendator::factory(),
            'status' => RentsStatus::getRandomValue(),
            'start_datetime' => $beginDateTime,
            'end_datetime' => rand(0, 1) ? $endDateTime : null,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Rent $rent) {
            if ($rent->status == RentsStatus::Open) {
                $car = Car::find($rent->car_id);
                $car->status == CarsStatus::Rented;
                $car->update();
            }
            elseif ($rent->status == RentsStatus::Closed) {
                $car = Car::find($rent->car_id);
                $car->status == rand(0, 1) ? CarsStatus::Maintenance : CarsStatus::Expectation;
                $car->update();
            }
        });
    }
}
