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
        $this->faker->addProvider(new \Faker\Provider\FakeCar($this->faker));
        return [
            'id' => fake()->uuid(),
            'model_id' => CarModel::factory(),
            'status' => CarsStatus::getRandomValue(),
            'mileage' => fake()->numberBetween(5000, 500000),
            'license_plate' => $this->faker->vehicleRegistration('[A-Z]{1}[0-9]{3}[A-Z]{2} [0-9]{2}'),
            'vin' => strtoupper($this->faker->unique()->vin),
            'location' => fake()->unique()->randomFloat(6, 55.70, 55.88) . ' ' . fake()->randomFloat(6, 37.37, 37.58),
            'price_minute' => fake()->randomFloat(2, 8, 25)
        ];
    }
}
