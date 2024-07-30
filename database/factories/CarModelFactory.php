<?php

namespace Database\Factories;

use App\Enums\DrivesType;
use App\Models\CarMark;
use Faker\Provider\FakeCarData;
use Faker\Provider\FakeCarHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarModel>
 */
class CarModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = (new \Faker\Factory())::create();
        $faker->addProvider(new \Faker\Provider\FakeCar($faker));
        return [
            'id' => fake()->uuid(),
            'mark_id' => CarMark::factory(),
            'name' => function (array $attributes) {
                return FakeCarHelper::getRandomElementFromArray(FakeCarData::$brandsWithModels[CarMark::find($attributes['mark_id'])->name]);
            },
            'car_type' => $faker->vehicleType,
            'fuel_type' => $faker->vehicleFuelType,
            'door_count' => $faker->vehicleDoorCount,
            'seat_count' => $faker->vehicleSeatCount,
            'gear_box' => $faker->vehicleGearBoxType,
            'drive_type' => DrivesType::getRandomValue(),
            'engine_power' => fake()->numberBetween(120, 300),
            'year' => fake()->year(),
        ];
    }
}
