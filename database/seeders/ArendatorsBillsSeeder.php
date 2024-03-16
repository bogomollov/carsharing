<?php

namespace Database\Seeders;

use App\Models\ArendatorBill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArendatorsBillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ArendatorBill::factory(20)->create();
    }
}
