<?php

namespace Database\Factories;

use App\Enums\BillsStatus;
use App\Enums\BillsType;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'balance' => fake()->randomFloat(2, 100.00, 5000.99),
            'type' => BillsType::Personal,
            'status' => BillsStatus::getRandomValue(),
        ];
    }
}
