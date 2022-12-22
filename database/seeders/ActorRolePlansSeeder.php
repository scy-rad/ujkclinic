<?php
//php artisan db:seed --class=ActorRolePlansSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ActorRolePlan;

class ActorRolePlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $actroleplane = new ActorRolePlan();
      $actroleplane->short = "pierwszoplanowa";
      $actroleplane->name = "aktor pierwszego planu";
      $actroleplane->descript = "postać najistotniejsza z punktu widzenia scenariusza symulacji";
      $actroleplane->save();

      $actroleplane = new ActorRolePlan();
      $actroleplane->short = "drugoplanowa";
      $actroleplane->name = "mistrz drugiego planu";
      $actroleplane->descript = "postać wzbogacająca przebieg symulacji";
      $actroleplane->save();
    }
}
