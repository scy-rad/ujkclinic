<?php
//php artisan db:seed --class=CenterSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Center;

class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role = new Center();
      $role->center_name = 'CSM Pielęgniarstwo';
      $role->center_short = 'Piel';
      $role->center_direct = 'pielęgniarstwo';
      $role->save();

      $role = new Center();
      $role->center_name = 'CSM Położnictwo';
      $role->center_short = 'Poł';
      $role->center_direct = 'położnictwo';
      $role->save();

  
      $role = new Center();
      $role->center_name = 'CSM Lekarski';
      $role->center_short = 'Lek';
      $role->center_direct = 'lekarski';
      $role->save();
  
      $role = new Center();
      $role->center_name = 'CSM Ratownictwo';
      $role->center_short = 'Rat';
      $role->center_direct = 'ratownictwo';
      $role->save();  
    }
}
