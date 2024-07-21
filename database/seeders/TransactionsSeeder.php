<?php

namespace Database\Seeders;

use App\Models\Arendator;
use App\Models\Rent;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (Rent::all()->where('status', 'closed') as $rents) {
            Transaction::create([
                'id' => fake()->uuid(),
                'arendator_id' => $rents->arendator_id,
                'bill_id' => Arendator::find($rents->arendator_id)->default_bill_id,
                'modification' => fake()->randomFloat(2, -5000, 5000),
            ]);
        }
    }
}
