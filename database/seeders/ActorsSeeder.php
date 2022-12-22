<?php
//php artisan db:seed --class=ActorsSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Actor;

class ActorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $actor = new Actor();
      $actor->scenario_id         = \App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
      $actor->actor_age_from      = 48;
      $actor->actor_age_to        = 68;
      $actor->actor_age_interval  = 1;  // 1 - lata,  2 - miesiąca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $actor->actor_sex           = 2;  // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
      $actor->actor_role_plan_id  = \App\Models\ActorRolePlan::where('short','pierwszoplanowa')->first()->id;
      $actor->actor_role_name     = 'pacjent';
      $actor->actor_type_id       = \App\Models\ActorType::where('short','SYM WW')->first()->id;
      $actor->history_for_actor   = 'Pacjent przez cały czas jest nieprzytomny';
      $actor->actor_simulation = "Pacjent z naklejonymi ranami ciętymi, z nieprawidłowo założoną rurką intubacyjną, z założonym wkłuciem obwodowym";
      $actor->actor_status = 1;
      $actor->save();	

      

      $actor = new Actor();  
      $actor->scenario_id         = \App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
      $actor->actor_age_from      = 42;
      $actor->actor_age_to        = 60;
      $actor->actor_age_interval  = 1;  // 1 - lata,  2 - miesiąca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $actor->actor_sex           = 2;  // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
      $actor->actor_role_plan_id  = \App\Models\ActorRolePlan::where('short','drugoplanowa')->first()->id;
      $actor->actor_role_name     = 'kolega poszkodowanego';
      $actor->actor_type_id       = \App\Models\ActorType::where('short','PAC STAND')->first()->id;
      $actor->history_for_actor   = 'Jesteś kolegą poszkodowanego. Wracaliście z imprezy firmowej, na której było sporo alkoholu, ale zapewniasz, że kierowca nie pił. Ty jesteś pijany i zachowujesz się głośno, martwiąc się o stan kolegi. Nie jesteś agresywny, ale dość natrętny. Jak Cię uciszają przepraszasz i siadasz na leżance, ale po chwili znowu podchodzisz i głośnio się zwracasz do lekarzy lub nieprzytomnego kolegi.';
      $actor->actor_simulation = "Pacjent z siniakiem na głowie, może mieć też małą ranę. Mocno wyczuwalna woń alkoholu.";
      $actor->actor_status = 1;
      $actor->save();	

      
      $actor = new Actor();
      $actor->scenario_id         = \App\Models\Scenario::where('scenario_code','PIEL-INT-PED-01')->first()->id;
      $actor->actor_age_from      = 28;
      $actor->actor_age_to        = 38;
      $actor->actor_age_interval  = 1;  // 1 - lata,  2 - miesiąca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $actor->actor_sex           = 1;  // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
      $actor->actor_role_plan_id  = \App\Models\ActorRolePlan::where('short','pierwszoplanowa')->first()->id;
      $actor->actor_role_name     = 'pacjent';
      $actor->actor_type_id       = \App\Models\ActorType::where('short','SYM WW')->first()->id;
      $actor->history_for_actor   = 'Pacjent przez cały czas jest nieprzytomny';
      $actor->actor_simulation = "Pacjent z naklejonymi ranami ciętymi, z nieprawidłowo założoną rurką intubacyjną, z założonym wkłuciem obwodowym";
      $actor->actor_status = 1;
      $actor->save();	

    }
}
