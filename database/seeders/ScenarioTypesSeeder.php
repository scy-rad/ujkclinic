<?php
//php artisan db:seed --class=ScenarioTypesSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ScenarioType;

class ScenarioTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scetype = new ScenarioType();
        $scetype->id = 1; 
        $scetype->short = "stand";
        $scetype->name = "pacjent standaryzowany";
        $scetype->descript = "symulacja z udziałem pacjenta standaryzowanego";
        $scetype->save();

        $scetype = new ScenarioType();
        $scetype->id = 2; 
        $scetype->short = "sym";
        $scetype->name = "symulator pacjenta";
        $scetype->descript = "symulacja z udziałem zaawansowanego symulatora pacjenta";
        $scetype->save();

        $scetype = new ScenarioType();
        $scetype->id = 4; 
        $scetype->short = "tren";
        $scetype->name = "trenażery";
        $scetype->descript = "zajęcia na trenażerach";
        $scetype->save();

        $scetype = new ScenarioType();
        $scetype->id = 8; 
        $scetype->short = "bez";
        $scetype->name = "zajęcia dodatkowe";
        $scetype->descript = "zajęcia bez wyposażenia";
        $scetype->save();
    }
    
}
