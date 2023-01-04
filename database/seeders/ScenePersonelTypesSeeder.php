<?php
//php artisan db:seed --class=ScenePersonelTypesSeeder

namespace Database\Seeders;

use App\Models\ScenePersonelType;
use Illuminate\Database\Seeder;

class ScenePersonelTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $personel_type = new ScenePersonelType();
      $personel_type->spt_name="edytor";
      $personel_type->spt_name_w="edytorka";
      $personel_type->spt_name_en="editor";
      $personel_type->spt_short="edytor";
      $personel_type->spt_short_en="editor";
      $personel_type->spt_description="osoba mogąca edytować Scenę";
      $personel_type->spt_code="editor";
      $personel_type->spt_color="red";
      $personel_type->save();

      $personel_type = new ScenePersonelType();
      $personel_type->spt_name="lekarz";
      $personel_type->spt_name_w="lekarka";
      $personel_type->spt_name_en="doctor";
      $personel_type->spt_short="lek.";
      $personel_type->spt_short_en="dr";
      $personel_type->spt_description="osoba grająca lakarkę lub lekarza";
      $personel_type->spt_code="doctor";
      $personel_type->spt_color="blue";
      $personel_type->save();

      $personel_type = new ScenePersonelType();
      $personel_type->spt_name="pielegniarz";
      $personel_type->spt_name_w="pielegniarka";
      $personel_type->spt_name_en="nurse";
      $personel_type->spt_short="dr";
      $personel_type->spt_short_en="nu.";
      $personel_type->spt_description="osoba grająca pielęgniarkę lub pielęgniarza";
      $personel_type->spt_code="doctor";
      $personel_type->spt_color="blue";
      $personel_type->save();

      $personel_type = new ScenePersonelType();
      $personel_type->spt_name="ratownik medyczny";
      $personel_type->spt_name_w="ratowniczka medyczna";
      $personel_type->spt_name_en="";
      $personel_type->spt_short="rat-med";
      $personel_type->spt_short_en="pm.";
      $personel_type->spt_description="osoba grająca ratownika lub ratowniczkę medyczną";
      $personel_type->spt_code="paramedic";
      $personel_type->spt_color="blue";
      $personel_type->save();

    }
}
