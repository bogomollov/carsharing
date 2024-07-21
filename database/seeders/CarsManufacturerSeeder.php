<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarManufacturer;

class CarsManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $manufacturers_names = array(
            'VAG',
            'General Motors',
            'FCA',
            'Daimler',
            'BMW',
        );
        foreach ($manufacturers_names as $name) {
            CarManufacturer::create([
                'id' => fake()->uuid(),
                'name' => $name,
            ]);
        }
    }
}