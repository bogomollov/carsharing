<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\BillsStatus;
use App\Enums\BillsType;
use App\Models\Bill;

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
            'balance' => fake()->randomFloat(null, 100.00, 5000.99),
        ];
    }
}
