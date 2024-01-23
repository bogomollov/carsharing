<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
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
            'id' => Str::uuid()->toString(),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName(null),
            'middle_name' => fake()->firstName(null),
            'passport_series' => fake()->unique()->numerify('## ##'),
            'passport_number' => fake()->unique()->numerify('######'),
            'phone' => fake()->unique()->numerify('79########'),
            'status' => ArendatorsStatus::getRandomValue()
        ];
    }
}
