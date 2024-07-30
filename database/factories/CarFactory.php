<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\CarsStatus;
use App\Models\CarModel;

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
        $faker = (new \Faker\Factory())::create();
        $faker->addProvider(new \Faker\Provider\FakeCar($faker));
        return [
            'id' => fake()->uuid(),
            'model_id' => CarModel::factory(),
            'status' => CarsStatus::getRandomValue(),
            'mileage' => fake()->numberBetween(30000, 100000),
            'license_plate' => $faker->vehicleRegistration('[A-Z]{1}[0-9]{3}[A-Z]{2} [0-9]{2}'),
            'vin' => strtoupper($faker->vin),
            'location' => fake()->randomFloat(2, -35, -50) . ' ' . fake()->randomFloat(2, -35, -50),
            'price_minute' => fake()->numberBetween(3, 18)
        ];
    }
}
