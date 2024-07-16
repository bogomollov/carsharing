<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ArendatorsStatus;
use App\Models\Arendator;
use App\Models\Bill;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ArendatorFactory extends Factory
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
            'default_bill_id' => Bill::factory(),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->firstName(),
            'passport_series' => fake()->unique()->numerify('## ##'),
            'passport_number' => fake()->unique()->numerify('######'),
            'phone' => fake()->unique()->numerify('79########'),
            'status' => ArendatorsStatus::getRandomValue()
        ];
    }
}
