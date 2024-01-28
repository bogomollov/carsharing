<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarsManufacturer;

class CarsManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $manufacturers_names = array(
            'VAG',
            'General Motors',
            'FCA',
            'Daimler',
            'BMW',
        );

        foreach ($manufacturers_names as $manufacturer_name) {
            CarsManufacturer::create([
                'name' => $manufacturer_name,
            ]);
        }
    }
}