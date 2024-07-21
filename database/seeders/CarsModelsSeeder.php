<?php

namespace Database\Seeders;

use App\Models\CarMark;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\CarModel;

class CarsModelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $models = array(
            ['Q6', 'Q3', 'Q5'],
            ['Cayene', '911'],
            ['Polo', 'Golf', 'Tuguan'],
            ['Escalade', 'CTS'],
            ['Impala', 'Cobalt', 'Camaro'],
            ['Grand Cherokee'],
            ['812'],
            ['CSL', '63AMG', 'GLE'],
            ['X5', 'X3'],
            ['Phantom'],
        );
        
        foreach ($models as $model) {
            foreach ($model as $name) {
                CarModel::create([
                    'id' => fake()->uuid(),
                    'mark_id' => CarMark::all('id')->random()->id,
                    'name' => $name,
                ]);
            }
        }
    }
}