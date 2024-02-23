<?php

namespace Database\Factories;

use App\Models\Arendators;
use App\Models\Bills;
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
                return Arendators::all('id')->random();
            },
            'bill_id' => function () {
                return Bills::all('id')->random();
            },
        ];
    }
}
