<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Rents;
use Illuminate\Database\Seeder;
use Database\Seeders\CarsMarksSeeder;
use Database\Seeders\CarsModelsSeeder;
use Database\Seeders\CarsManufacturerSeeder;
use Database\Seeders\CarsSeeder;
use Database\Seeders\ArendatorsBillsSeeder;
use Database\Seeders\BillsSeeder;
use Database\Seeders\TransactionsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CarsManufacturerSeeder::class);
        $this->call(CarsModelsSeeder::class);
        $this->call(CarsMarksSeeder::class);
        $this->call(CarsSeeder::class);
        $this->call(BillsSeeder::class);
        $this->call(ArendatorsSeeder::class);
        $this->call(ArendatorsBillsSeeder::class);
        $this->call(Rents::class);
        $this->call(TransactionsSeeder::class);
    }
}
