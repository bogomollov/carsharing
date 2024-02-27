<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cars;
use App\Models\Arendators;
use App\Models\User;
use App\Models\Bills;
use App\Models\Rents;
use App\Models\Transactions;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cars::factory(20)->create();
        Arendators::factory(20)->create();
        Bills::factory(20)->create();
        Transactions::factory(20)->create();
        Rents::factory(20)->create();
        User::factory(20)->create();
    }
}
