<?php
//php artisan db:seed --class=ScenariosSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Scenario;
use App\Models\Actor;
use App\Models\LabTemplate;
use App\Models\LabTemplateResult;



class ScenariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      function add_test_result($template_id,$norm_short,$result,$resulttxt,$addedtext,$type,$sort)
      {
        $lr_t_result = new LabTemplateResult();
        $lr_t_result->lab_template_id = $template_id;
        $lr_t_result->laboratory_test_id = \App\Models\LaboratoryTest::where('lt_short',$norm_short)->first()->id;;
        $lr_t_result->lrtr_result     = $result;
        $lr_t_result->lrtr_resulttxt  = $resulttxt;
        $lr_t_result->lrtr_addedtext  = $addedtext;
        $lr_t_result->lrtr_type       = $type;
        $lr_t_result->lrtr_sort        = $sort;
        $lr_t_result->save();
        return $lr_t_result->id;
      }

      
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

      $actor = new Actor();
      $actor->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','PIEL-INT-PED-01')->first()->id;
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

      $lr_template = new LabTemplate();
      $lr_template->actor_id    = $actor->id;
      $lr_template->description_for_leader = 'wyniki badań z wizyty w poradni dzień wcześniej';
      $lr_template->lrt_minutes_before = 60*24-72;
      $lr_template->lrt_type    = 1;
      $lr_template->lrt_sort    = 1;
      $lr_template->save();

      add_test_result($lr_template->id,'Hb',113,'','',1,1);
      add_test_result($lr_template->id,'Ht',38,'','',1,1);
      add_test_result($lr_template->id,'RBC',49,'','',1,1);
      add_test_result($lr_template->id,'MCV',72,'','',1,1);
      add_test_result($lr_template->id,'MCH',39,'','',1,1);
      add_test_result($lr_template->id,'mocz_kolor',null,'pomarańczowy','',2,1);

      $lr_template = new LabTemplate();
      $lr_template->actor_id    = $actor->id;
      $lr_template->description_for_leader = 'szablon wyników z Izby Przyjęć';
      $lr_template->lrt_minutes_before = 0;
      $lr_template->lrt_type    = 2;
      $lr_template->lrt_sort    = 2;
      $lr_template->save();

      add_test_result($lr_template->id,'Hb',109,'','',2,1);
      add_test_result($lr_template->id,'Ht',375,'','',2,1);
      add_test_result($lr_template->id,'RBC',48,'','',2,1);
      add_test_result($lr_template->id,'MCV',80,'','',2,1);
      add_test_result($lr_template->id,'MCH',34,'','',2,1);
      add_test_result($lr_template->id,'mocz_kolor',null,'słomkowy','',2,1);


      // ####################################################################################

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

      $actor = new Actor();
      $actor->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
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
      $actor->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
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



    }
}
