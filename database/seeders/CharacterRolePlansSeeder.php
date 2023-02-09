<?php
//php artisan db:seed --class=CharacterRolePlansSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CharacterRolePlan;

class CharacterRolePlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $actroleplane = new CharacterRolePlan();
      $actroleplane->short = "pierwszoplanowa";
      $actroleplane->name = "aktor pierwszego planu";
      $actroleplane->descript = "postać najistotniejsza z punktu widzenia scenariusza symulacji";
      $actroleplane->save();

      $actroleplane = new CharacterRolePlan();
      $actroleplane->short = "drugoplanowa";
      $actroleplane->name = "mistrz drugiego planu";
      $actroleplane->descript = "postać wzbogacająca przebieg symulacji";
      $actroleplane->save();
    }
}
