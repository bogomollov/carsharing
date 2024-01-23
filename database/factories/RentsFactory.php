<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\CarsStatus;
use App\Enums\RentsStatus;
use App\Models\Arendators;
use App\Models\Cars;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RentsFactory extends Factory
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
        return [
            'id' => Str::uuid(),
            'car_id' => function () use ($status) {
                if ($status == 'open') {
                    return Cars::factory()->create(['status' => CarsStatus::Rented])->id;
                } else {
                    return Cars::factory()->create()->id;
                }
            },
            'arendator_id' => Arendators::all()->whereNotNull('bill_id')->random(),
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
