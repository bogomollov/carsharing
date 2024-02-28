<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ArendatorsStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ArendatorsFactory extends Factory
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
