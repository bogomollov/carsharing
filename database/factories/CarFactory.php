<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\CarsStatus;
use App\Models\CarModel;
use App\Models\Car;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $licensePlate = mb_strtoupper(fake()->randomLetter() . 
        fake()->randomDigit() .
        fake()->randomDigit() .
        fake()->randomDigit() . 
        fake()->randomLetter() . fake()->randomLetter()
        . ' ' . fake()->randomDigit() . fake()->randomDigit());

        return [
            'id' => fake()->uuid(),
            'model_id' => CarModel::all('id')->random(),
            'status' => CarsStatus::getRandomValue(),
            'mileage' => fake()->numberBetween(30000, 100000),
            'license_plate' => $licensePlate,
            'year' => fake()->year(),
            'location' => fake()->randomFloat(2, -35, -50) . ' ' . fake()->randomFloat(2, -35, -50),
            'price_minute' => fake()->numberBetween(3, 18)
        ];
    }
}
