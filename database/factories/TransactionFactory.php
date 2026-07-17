<?php

namespace Database\Factories;

use App\Models\Arendator;
use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
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
            'arendator_id' => Arendator::factory(),
            'bill_id' => Bill::factory(),
            'modification' => fake()->randomFloat(2, -5000, 5000),
        ];
    }
}
