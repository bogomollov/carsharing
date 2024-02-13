<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarsMarks;

class CarsMarksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = array(
            1 => ['Audi', 'Porsche', 'Volkswagen'],
            2 => ['Cadillac', 'Chevrolet'],
            3 => ['Jeep', 'Ferrari'],
            4 => ['Mercedes-Benz'],
            5 => ['BMW', 'Rolls-Royce'],
        );

        foreach ($brands as $key => $value) {
            foreach ($value as $brand_name) {
                CarsMarks::create([
                    'manufacturer_id' => $key,
                    'name' => $brand_name,
                ]);
            }
        }
    }
}