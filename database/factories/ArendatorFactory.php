<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ArendatorsStatus;
use App\Models\Bill;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ArendatorFactory extends Factory
{
    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'email' => fake()->unique()->safeEmail(), 
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'default_bill_id' => Bill::factory(),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->firstName(),
            'passport_series' => fake()->numerify('## ##'),
            'passport_number' => fake()->unique()->numerify('######'),
            'driverlicense_series' =>fake()->numerify('## ##'),
            'driverlicense_number' => fake()->unique()->numerify('######'),
            'driverlicense_date' => fake()->date('d.m.Y'),
            'phone' => fake()->unique()->numerify('79########'),
            'status' => ArendatorsStatus::getRandomValue()
        ];
    }
}
