<?php
//php artisan db:seed --class=CharacterTypesSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CharacterType;

class CharacterTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $acttype = new CharacterType();
      $acttype->short = "PAC STAND";
      $acttype->name = "pacjent standaryzowany";
      $acttype->descript = "człowiek - najczęściej aktor, ale też może student lub inna osoba";
      $acttype->save();

      $acttype = new CharacterType();
      $acttype->short = "SYM WW";
      $acttype->name = "symulator WW";
      $acttype->descript = "symulator pozwalający na monitorowanie i ustawianie parametrów";
      $acttype->save();

      $acttype = new CharacterType();
      $acttype->short = "MAN";
      $acttype->name = "manekin";
      $acttype->descript = "manekin pełnopostaciowy bez konieczności monitorowania";
      $acttype->save();

      $acttype = new CharacterType();
      $acttype->short = "TREN";
      $acttype->name = "trenażer";
      $acttype->descript = "trenażer do ćwiczenia konkretnych czynności";
      $acttype->save();
    }
}
