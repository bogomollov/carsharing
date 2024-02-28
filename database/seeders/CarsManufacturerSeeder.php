<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarsManufacturers;
use Illuminate\Support\Str;

class CarsManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $names = array(
            'VAG',
            'General Motors',
            'FCA',
            'Daimler',
            'BMW',
        );

        foreach ($names as $manufacturer_name) {
            CarsManufacturers::create([
                'id' => Str::uuid(),
                'name' => $manufacturer_name,
            ]);
        }
    }
}