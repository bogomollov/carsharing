<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\BillsStatus;
use Illuminate\Support\Str;
use App\Models\Arendators;

class BillsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'arendator_id' => Arendators::inRandomOrder()->first()->id,
            'balance' => fake()->numberBetween(0, 1000000),
            'status' => BillsStatus::getRandomValue()
        ];
    }
}
