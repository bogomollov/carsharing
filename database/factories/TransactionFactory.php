<?php

namespace Database\Factories;

use App\Models\Arendator;
use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'arendator_id' => Arendator::factory(),
            'bill_id' => Bill::factory(),
            'modification' => fake()->randomFloat(2, -5000, 5000),
        ];
    }
}
