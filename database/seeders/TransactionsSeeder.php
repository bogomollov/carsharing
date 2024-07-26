<?php

namespace Database\Seeders;

use App\Models\Arendator;
use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Transaction::factory()->count(10)->create();
    }
}
