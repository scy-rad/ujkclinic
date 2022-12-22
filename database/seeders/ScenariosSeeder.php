<?php
//php artisan db:seed --class=ScenariosSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Scenario;


class ScenariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $scenario = new Scenario();
      // $scenario->scenario_author_id = null;
      $scenario->scenario_author_id = \App\Models\User::where('name','instruktor')->first()->id;
      $scenario->center_id        =  \App\Models\Center::where('center_short','Piel')->first()->id;
      $scenario->scenario_type_id =  \App\Models\ScenarioType::where('short','sym')->first()->id;
      $scenario->scenario_name  = 'scenariusz testowy pierwszy';
      $scenario->scenario_code  = 'PIEL-INT-PED-01';
      $scenario->scenario_main_problem = 'złamanie otwarte nogi';
      $scenario->scenario_description = 'chłopczyk przewrócił się na rowerze i doznał złamania otwartego ręki z raną ciętą skroni';
      $scenario->scenario_for_students = 'Jesteście lekarzami na Izbie Przyjęć. ZRM przywiózł Wam pacjenta (kierowcę) z wypadku samochodowego, u któego nastąpiło zatrzymanie krążenia. Krążenie wróciło w karetce.';
      $scenario->scenario_for_leader  = 'Poszkodowany został przywieziony nieprawidłowo zaintubowany.';
      $scenario->scenario_helpers_for_students= '<ul><li>jeśli zespół nie zauważy nieprawidłowej intubacji, może wejść pielęgniarka żeby podłączyć pompę innemu pacjentowi i zauważyć, że klatka piersiowa nie porusza się podczas wentylacji</li></ul>';
      $scenario->scenario_logs_for_students   = '<ul><li>może zadzwonić żona i powiedzieć, że mąż ostatnio źle się czuł, był częśto zmęczny i narzekał na serce</li></ul>';
      $scenario->scenario_status	= 1;
      $scenario->save();

      $scenario = new Scenario();
      $scenario->scenario_author_id = null;
      // $scenario->scenario_author_id = \App\Models\User::where('name','instruktor')->first()->id;
      $scenario->center_id        =  \App\Models\Center::where('center_short','Lek')->first()->id;
      $scenario->scenario_type_id =  \App\Models\ScenarioType::where('short','sym')->first()->id;
      $scenario->scenario_name  = 'scenariusz testowy drugi';
      $scenario->scenario_code  = 'LEK-INT-PED-01';
      $scenario->scenario_main_problem = 'złamanie otwarte nogi, wstrząśnienie mózgu';
      $scenario->scenario_description = 'chłopczyk przewrócił się na rowerze i doznał złamania otwartego ręki z raną ciętą skroni. Podejrzenie wstrząśnienia mózgu.';
      $scenario->scenario_for_students = 'Jesteście lekarzami na Izbie Przyjęć. ZRM przywiózł Wam pacjenta/kę (kierowcę) z wypadku samochodowego, u którego/ej nastąpiło zatrzymanie krążenia. Krążenie wróciło w karetce.';
      $scenario->scenario_for_leader  = 'Poszkodowany został przywieziony nieprawidłowo zaintubowany.';
      $scenario->scenario_helpers_for_students= '<ul><li>Zabranie dystraktora na badania obrazowe</li></ul>';
      $scenario->scenario_logs_for_students   = '<ul><li>Dystraktor odbiera telefon od żony poszkodowanego i zaczyna się zościć i głośno zachowywać nie dając się uciszyć</li></ul>';
      $scenario->scenario_status	= 1;
      $scenario->save();

    }
}
