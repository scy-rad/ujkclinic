<?php
//php artisan db:seed --class=SceneTypesSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SceneType;

class SceneTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scetype = new SceneType();
        $scetype->id = 1; 
        $scetype->scene_type_code = "hospital";
        $scetype->scene_type_name = "szpital";
        $scetype->scene_type_blade = "scene.show_hospital";
        $scetype->scene_type_descript = "Symulacja oddziału szpitalnego";
        $scetype->save();

        $scetype = new SceneType();
        $scetype->id = 2; 
        $scetype->scene_type_code = "medical_center";
        $scetype->scene_type_name = "przychodnia";
        $scetype->scene_type_blade = "scene.show_medicalcenter";
        $scetype->scene_type_descript = "Symulacja przychodni lekarskiej";
        $scetype->save();


    }
    
}
