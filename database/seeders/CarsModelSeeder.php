<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarsModel;

class CarsModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $models = array(
            1 => ['Q6', 'Q3', 'Q5'],
            2 => ['Cayene', '911'],
            3 => ['Polo', 'Golf', 'Tuguan'],
            4 => ['Escalade', 'CTS'],
            5 => ['Impala', 'Cobalt', 'Camaro'],
            6 => ['Grand Cherokee'],
            7 => ['812'],
            8 => ['CSL', '63AMG', 'GLE'],
            9 => ['X5', 'X3'],
            10 => ['Phantom'],
        );

        foreach ($models as $key => $value) {
            foreach ($value as $model_name) {
                CarsModel::create([
                    'name' => $model_name,
                    'mark_id' => $key,
                ]);
            }
        }
    }
}