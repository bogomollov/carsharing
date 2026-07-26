<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Arendator;

class ArendatorSeeder extends Seeder
{
    public function run(): void
    {
        Arendator::factory()->count(20)->create();
    }
}
