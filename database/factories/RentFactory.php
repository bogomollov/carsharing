<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\CarsStatus;
use App\Enums\RentsStatus;
use App\Models\Arendator;
use App\Models\Car;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory>
 */
class RentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $beginDateTime = fake()->dateTimeBetween($startDate = '-365 days', $endDate = 'now', $timezone = null);
        $endDateTime = fake()->dateTimeInInterval($beginDateTime, $endDate = '+1 days', $timezone = null);
        
        $status = RentsStatus::getRandomValue();

        return [
            'id' => fake()->uuid(),
            'car_id' => function () use ($status) {
                if ($status == 'open') {
                    return Car::factory()->create(['status' => CarsStatus::Rented])->id;
                } else {
                    return Car::factory()->create()->id;
                }
            },
            'arendator_id' => Arendator::all()->random(),
            'status' => $status,
            'start_datetime' => $beginDateTime,
            'end_datetime' => function () use ($status, $endDateTime) {
                if ($status === RentsStatus::Open) {
                    return null;
                } else {
                    return $endDateTime;
                }
            },
        ];
    }
}
