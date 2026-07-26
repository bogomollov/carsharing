<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarModel;

class CarModelSeeder extends Seeder
{

    public function run()
    {
        CarModel::factory()->create();
    }
}