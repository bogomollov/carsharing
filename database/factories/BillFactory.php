<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\BillsStatus;

class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'balance' => fake()->numberBetween(0, 1000000),
            'status' => BillsStatus::getRandomValue()
        ];
    }
}
