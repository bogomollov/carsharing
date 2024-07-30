<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\BillSeeder;
use Database\Seeders\RentSeeder;
use Database\Seeders\TransactionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CarModelSeeder::class);
        $this->call(BillSeeder::class);
        $this->call(ArendatorSeeder::class);
        $this->call(RentSeeder::class);
        $this->call(TransactionSeeder::class);
    }
}
