<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarMarkFactory extends Factory
{
    public function definition(): array
    {
        $this->faker->addProvider(new \Faker\Provider\FakeCar($this->faker));
        return [
            'id' => fake()->uuid(),
            'name' => $this->faker->unique()->vehicleBrand(),
        ];
    }
}
