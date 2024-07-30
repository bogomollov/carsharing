<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarMark>
 */
class CarMarkFactory extends Factory
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
            'name' => $this->faker->unique()->vehicleBrand(),
        ];
    }
}
