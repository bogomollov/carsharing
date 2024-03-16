<?php

namespace Database\Factories;

use App\Models\Arendator;
use App\Models\Bill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArendatorsBillsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'arendator_id' => function () {
                return Arendator::all('id')->random();
            },
            'bill_id' => function () {
                return Bill::all('id')->random();
            },
        ];
    }
}
