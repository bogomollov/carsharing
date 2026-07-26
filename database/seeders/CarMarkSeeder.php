<?php

namespace Database\Seeders;

use App\Models\CarMark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarMarkSeeder extends Seeder
{
    public function run(): void
    {
        CarMark::factory()->create();
    }
}
