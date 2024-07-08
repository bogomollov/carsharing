<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Arendator;

class ArendatorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Arendator::factory(20)->create();
    }
}
