<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\CarsStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CarsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'model_id' => Str::uuid(),
            'status' => CarsStatus::getRandomValue(),
            'mileage' => fake()->numberBetween(30000, 100000),
            'location' => fake()->randomFloat(2, -35, -50) . ' ' . fake()->randomFloat(5, -35, -50),
            'price_minute' => fake()->numberBetween(3, 18)
        ];
    }
}
