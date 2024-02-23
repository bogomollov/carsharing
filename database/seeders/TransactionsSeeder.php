<?php

namespace Database\Seeders;

use App\Models\Arendators;
use App\Models\Rents;
use App\Models\Transactions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (Rents::all()->where('status', 'closed') as $rents) {
            Transactions::create([
                'id' => Str::uuid(),
                'arendator_id' => $rents->arendator_id,
                'bill_id' => Arendators::find($rents->arendator_id)->default_bill_id,
                'datetime' => $rents->end_datetime,
            ]);
        }
    }
}
