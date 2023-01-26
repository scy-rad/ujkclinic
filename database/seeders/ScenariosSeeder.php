<?php
//php artisan db:seed --class=ScenariosSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Scenario;
use App\Models\Actor;
use App\Models\LabOrderTemplate;
use App\Models\LabResultTemplate;
use Illuminate\Support\Facades\Schema;

class ScenariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      Schema::disableForeignKeyConstraints();
      LabResultTemplate::truncate();
      LabOrderTemplate::truncate();
      Actor::truncate();
      Scenario::truncate();
      Schema::enableForeignKeyConstraints();

      function add_test_result($template_id,$norm_short,$result,$resulttxt,$addedtext,$type,$sort)
      {
        $lr_t_result = new LabResultTemplate();
        $lr_t_result->lab_order_template_id = $template_id;
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
      $scenario->scenario_name  = 'niedokrwistość';
      $scenario->scenario_code  = 'ZK-HEM-01';
      $scenario->scenario_main_problem = '';
      $scenario->scenario_description = 'Pacjentka przetransportowana przez ZRM do SOR zgłasza utratę przytomności, duszność, zawroty głowy, zwiększoną męczliwość. Po zebraniu wywiadu grupa powinna wykluczyć możliwe przyczyny zgłaszanych objawów takie jak ponowny zawał serca, zatorowość płucna, ostre choroby układu oddechowego oraz ukierunkować swoje podejrzenia na niedokrwistość. Zaplanować wstępną diagnostykę różnicową niedokrwistości, wykonać podstawowe badania pomocnicze (morfologia krwi obwodowej, parametry gospodarki żelazowej, ewentualne badania obrazowe przewodu pokarmowego dostępne na SOR), włączyć konieczne leczenie (w sytuacji konieczności przygotowanie do zamówienia, zamówienie i przetoczenie KKCz, lub skierowanie na oddział wewnętrzny celem przetoczenia składników krwi i dalszej diagnostyki)';
      $scenario->scenario_for_students = '70-letnia kobieta została przetransportowana do SOR  przez ZRM z powodu utraty przytomności, podczas spaceru.';
      $scenario->scenario_for_leader  = '<p>
      <b>Główne dolegliwości</b>: Utrata przytomności, duszność, bóle i zawroty głowy, osłabienie i łatwa męczliwość<br>
      <b>Dotychczasowy przebieg choroby</b>: Od miesiąca odczuwa nasilającą się męczliwość, musi odpoczywać jak wchodzi po schodach. Bóle brzucha nasilające się na czczo, ustępujące po spożyciu pokarmu.<br>
      <b>Choroby przewlekłe</b>: Przebyty STEMI ściany dolnej 6 lat temu powikłany niedomykalnością zastawki mitralnej, nadciśnienie tętnicze od 20 lat, miażdżyca, przewlekłe bóle kręgosłupa.<br>
      <b>Leki</b>: Acard 75mg/d; Bibloc 10mg/d; Lisiprol 20mg/d; Atoris 10mg/d; Ibalgin MAXI doraźnie<br>
      <b>Zabiegi operacyjne</b>: Angioplastyka naczyń wieńcowych z wszczepieniem DES 6 lat temu, usunięty pęcherzyk zółciowy 15 lat temu.<br>
      <b>Uczulenia</b>: neguje<br>
      <b>Nałogi</b>: tytoń - neguje; alkohol - okazjonalnie<br>
      <b>Wywiad rodzinny</b>: ojciec rak jelita grubego, matka cukrzyca, nadciśnienie tętnicze, nowotwór żeńskich narządów rodnych. <br>
      <b>Wywiad społeczny</b>: emerytka, mieszka z mężem
      </p>';
      $scenario->scenario_helpers_for_students= '';
      $scenario->scenario_logs_for_students   = '';
      $scenario->scenario_status	= 1;
      $scenario->save();

      $actor = new Actor();
      $actor->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','PIEL-INT-PED-01')->first()->id;
      $actor->actor_incoming_recalculate      = 0;
      $actor->actor_age_from      = 65;
      $actor->actor_age_to        = 78;
      $actor->actor_age_interval  = 1;  // 1 - lata,  2 - miesiąca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $actor->actor_sex           = 3;  // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
      $actor->actor_role_plan_id  = \App\Models\ActorRolePlan::where('short','pierwszoplanowa')->first()->id;
      $actor->actor_role_name     = 'Konieta z niedokrwistością';
      $actor->actor_type_id       = \App\Models\ActorType::where('short','SYM WW')->first()->id;
      $actor->history_for_actor   = 'Zgłaszasz utratę przytomności, duszność, zawroty głowy, zwiększoną męczliwość. Nie miałaś wcześniej problemów z sercem.';
      $actor->actor_simulation = "Starsza kobieta";
      $actor->actor_status = 1;
      $actor->save();	


      $lr_template = new LabOrderTemplate();
      $lr_template->actor_id    = $actor->id;
      $lr_template->description_for_leader = 'wyniki badań z SOR';
      $lr_template->lrt_minutes_before = 0;
      $lr_template->lrt_type    = 1;
      $lr_template->lrt_sort    = 2;
      $lr_template->save();

     
      


      add_test_result($lr_template->id,'RBC','33','','',1,1);
add_test_result($lr_template->id,'RTC','700','','',1,1);
add_test_result($lr_template->id,'MCV','730','','',1,1);
add_test_result($lr_template->id,'MCH','240','','',1,1);
add_test_result($lr_template->id,'MCHC','310','','',1,1);
add_test_result($lr_template->id,'Hb','68','','',1,1);
add_test_result($lr_template->id,'HCT','310','','',1,1);
add_test_result($lr_template->id,'WBC','51000','','',1,1);

add_test_result($lr_template->id,'NEUT','17','','',1,1);
add_test_result($lr_template->id,'EOS','3','','',1,1);
add_test_result($lr_template->id,'BASO','1','','',1,1);
add_test_result($lr_template->id,'LYM','24','','',1,1);
add_test_result($lr_template->id,'MONO','5','','',1,1);
add_test_result($lr_template->id,'PLT','350','','',1,1);


add_test_result($lr_template->id,'PT','14','','',1,1);
add_test_result($lr_template->id,'INR','97','','',1,1);
add_test_result($lr_template->id,'aPTT','31','','',1,1);
add_test_result($lr_template->id,'TT','17','','',1,1);


add_test_result($lr_template->id,'D-DIMERY','4890','','',1,1);

add_test_result($lr_template->id,'RBC','33','','',1,1);
add_test_result($lr_template->id,'RTC','700','','',1,1);
add_test_result($lr_template->id,'MCV','730','','',1,1);
add_test_result($lr_template->id,'MCH','240','','',1,1);
add_test_result($lr_template->id,'MCHC','310','','',1,1);
add_test_result($lr_template->id,'Hb','68','','',1,1);
add_test_result($lr_template->id,'HCT','31','','',1,1);
add_test_result($lr_template->id,'WBC','51000','','',1,1);

add_test_result($lr_template->id,'NEUT','17','','',1,1);
add_test_result($lr_template->id,'EOS','3','','',1,1);
add_test_result($lr_template->id,'BASO','1','','',1,1);
add_test_result($lr_template->id,'LYM','24','','',1,1);
add_test_result($lr_template->id,'MONO','5','','',1,1);
add_test_result($lr_template->id,'PLT','350','','',1,1);


add_test_result($lr_template->id,'PT','14','','',1,1);
add_test_result($lr_template->id,'INR','97','','',1,1);
add_test_result($lr_template->id,'aPTT','31','','',1,1);
add_test_result($lr_template->id,'TT','17','','',1,1);


add_test_result($lr_template->id,'D-DIMERY','4890','','',1,1);

add_test_result($lr_template->id,'OB','12','','',1,1);
add_test_result($lr_template->id,'CRP','1700','','',1,1);
add_test_result($lr_template->id,'LDH','270','','',1,1);
add_test_result($lr_template->id,'UA','234','','',1,1);

add_test_result($lr_template->id,'GLUKOZA','1700','','',1,1);

add_test_result($lr_template->id,'KREATYNINA','85','','',1,1);
add_test_result($lr_template->id,'MOCZNIK','210','','',1,1);

add_test_result($lr_template->id,'POTAS','42','','',1,1);
add_test_result($lr_template->id,'SÓD','142','','',1,1);
add_test_result($lr_template->id,'Chlorki','101','','',1,1);
add_test_result($lr_template->id,'FOSFOR','92','','',1,1);
add_test_result($lr_template->id,'WAPŃ całkowity','25','','',1,1);

add_test_result($lr_template->id,'AlAT','32','','',1,1);
add_test_result($lr_template->id,'AspAT','21','','',1,1);

add_test_result($lr_template->id,'BILIRUBINA','8','','',1,1);
add_test_result($lr_template->id,'AMYLAZA','270','','',1,1);

add_test_result($lr_template->id,'CK','201','','',1,1);








add_test_result($lr_template->id,'pH (BOM)','55','','',1,1);
add_test_result($lr_template->id,'ciężar_właściwy','1030','','',1,1);
add_test_result($lr_template->id,'kolor','0','żółty','',1,1);
add_test_result($lr_template->id,'białko (BOM)','0','nieobecne','',1,1);
add_test_result($lr_template->id,'glukoza (BOM)','0','nieobecna','',1,1);
add_test_result($lr_template->id,'ketony','0','nieobecne','',1,1);
add_test_result($lr_template->id,'bilirubina','0','nieobecna','',1,1);
add_test_result($lr_template->id,'urobilinogen','10','','',1,1);







add_test_result($lr_template->id,'OB','12','','',1,1);
add_test_result($lr_template->id,'CRP','1700','','',1,1);
add_test_result($lr_template->id,'LDH','270','','',1,1);
add_test_result($lr_template->id,'UA','234','','',1,1);

add_test_result($lr_template->id,'GLUKOZA','1700','','',1,1);

add_test_result($lr_template->id,'KREATYNINA','85','','',1,1);
add_test_result($lr_template->id,'MOCZNIK','210','','',1,1);

add_test_result($lr_template->id,'POTAS','42','','',1,1);
add_test_result($lr_template->id,'SÓD','142','','',1,1);
add_test_result($lr_template->id,'CHLORki','101','','',1,1);
add_test_result($lr_template->id,'FOSFOR','92','','',1,1);


add_test_result($lr_template->id,'AlAT','32','','',1,1);
add_test_result($lr_template->id,'AspAT','21','','',1,1);


add_test_result($lr_template->id,'AMYLAZA','270','','',1,1);

add_test_result($lr_template->id,'CK','201','','',1,1);







      $scenario = new Scenario();
      // $scenario->scenario_author_id = null;
      $scenario->scenario_author_id = \App\Models\User::where('name','instruktor')->first()->id;
      $scenario->center_id        =  \App\Models\Center::where('center_short','Piel')->first()->id;
      $scenario->scenario_type_id =  \App\Models\ScenarioType::where('short','sym')->first()->id;
      $scenario->scenario_name  = 'scenariusz testowy pierwszy';
      $scenario->scenario_code  = 'PIEL-INT-PED-01';
      $scenario->scenario_main_problem = 'Oddział pediatryczny';
      $scenario->scenario_description = 'Dziecko przewróciło się na rowerze i doznało złamania otwartego ręki z raną ciętą skroni. Na oddziale jest już dwójka innych dzieci';
      $scenario->scenario_for_students = 'Jesteście lekarzami na Izbie Przyjęć. ZRM przywiezie Wam półprzytomne dziecko, które zostalo potrącone przez pijanego kierowcę samochodu. Wynki badań z karetki powinny być już dostępne w systemie szpitalnym.';
      $scenario->scenario_for_leader  = 'Dziecko choruje na cukrzycę i w trakcie transportu na Izbę Przyjęć cukier znacznie spadł (czego nie widać w wynikach z karetki';
      $scenario->scenario_helpers_for_students= '<ul><li>jeśli zespół nie powiąże pogarszania się stanu dziecka z cukrzycą, może zadzwonić mama z tą informację</li></ul>';
      $scenario->scenario_logs_for_students   = '<ul><li>n salę może wejść pijany kierowca, któy potrącł dziecko, a teraz chce je stamtąd zabrać, bo wszystko jest w porządku i on wszystko załatwi z rodzicami dziecka.</li></ul>';
      $scenario->scenario_status	= 1;
      $scenario->save();

      $actor = new Actor();
      $actor->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','PIEL-INT-PED-01')->first()->id;
      $actor->actor_incoming_recalculate      = 0;
      $actor->actor_age_from      = 11;
      $actor->actor_age_to        = 15;
      $actor->actor_age_interval  = 1;  // 1 - lata,  2 - miesiąca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $actor->actor_sex           = 1;  // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
      $actor->actor_role_plan_id  = \App\Models\ActorRolePlan::where('short','pierwszoplanowa')->first()->id;
      $actor->actor_role_name     = 'poszkodowane dziecko';
      $actor->actor_type_id       = \App\Models\ActorType::where('short','SYM WW')->first()->id;
      $actor->history_for_actor   = 'Dziecko na początku jest w słabym kontakcie, po chwili całkowicie traci przytomnośc z powodu spadku cukru';
      $actor->actor_simulation = "Pacjent z zadrapaniami na twarzy i rękach. Może mieć złamanie lub opatrunek uciskowy na kończynie";
      $actor->actor_status = 1;
      $actor->save();	

      $lr_template = new LabOrderTemplate();
      $lr_template->actor_id    = $actor->id;
      $lr_template->description_for_leader = 'wyniki badań z wizyty w poradni dzień wcześniej';
      $lr_template->lrt_minutes_before = 60*24-72;  //24 godziny wczesniej bez 72 minut
      $lr_template->lrt_type    = 1;
      $lr_template->lrt_sort    = 1;
      $lr_template->save();

      add_test_result($lr_template->id,'Hb',113,'','',1,1);
      add_test_result($lr_template->id,'HCT',38,'','',1,1);
      add_test_result($lr_template->id,'RBC',49,'','',1,1);
      add_test_result($lr_template->id,'MCV',72,'','',1,1);
      add_test_result($lr_template->id,'MCH',39,'','',1,1);
      add_test_result($lr_template->id,'Szybki',312,'','',1,1);
      add_test_result($lr_template->id,'Średni',150,'','',1,1);
      add_test_result($lr_template->id,'Wolny',150,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'zielony','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);

      $lr_template = new LabOrderTemplate();
      $lr_template->actor_id    = $actor->id;
      $lr_template->description_for_leader = 'szablon wyników z Izby Przyjęć';
      $lr_template->lrt_minutes_before = 0;
      $lr_template->lrt_type    = 2;
      $lr_template->lrt_sort    = 2;
      $lr_template->save();

      add_test_result($lr_template->id,'Hb',109,'','',2,1);
      add_test_result($lr_template->id,'HCT',375,'','',2,1);
      add_test_result($lr_template->id,'RBC',48,'','',2,1);
      add_test_result($lr_template->id,'MCV',80,'','',2,1);
      add_test_result($lr_template->id,'MCH',34,'','',2,1);
      add_test_result($lr_template->id,'Szybki',312,'','',1,1);
      add_test_result($lr_template->id,'Średni',149,'','',1,1);
      add_test_result($lr_template->id,'Wolny',149,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'pomarańczowy','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);

      $actor = new Actor();
      $actor->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','PIEL-INT-PED-01')->first()->id;
      $actor->actor_incoming_recalculate      = 24*60*2+188; // 2 dni 3 godz i 8 minut wcześniej
      $actor->actor_age_from      = 7;
      $actor->actor_age_to        = 7;
      $actor->actor_age_interval  = 4;  // 1 - lata,  2 - miesiąca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $actor->actor_sex           = 1;  // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
      $actor->actor_role_plan_id  = \App\Models\ActorRolePlan::where('short','pierwszoplanowa')->first()->id;
      $actor->actor_role_name     = 'tygodniowy noworodek';
      $actor->actor_type_id       = \App\Models\ActorType::where('short','MAN')->first()->id;
      $actor->history_for_actor   = 'Dziecko leży i czasami popłakuje';
      $actor->actor_simulation = "Jeśli dziecko byłoby istotne z punktu widzenia symulacji - to tu byłoby o tym napisane";
      $actor->actor_status = 1;
      $actor->save();	

      $lr_template = new LabOrderTemplate();
      $lr_template->actor_id    = $actor->id;
      $lr_template->description_for_leader = 'wyniki badań z przyjęcia';
      $lr_template->lrt_minutes_before = 23*60+33;  //23 godziny i 33 minuty wczesniej
      $lr_template->lrt_type    = 1;
      $lr_template->lrt_sort    = 1;
      $lr_template->save();

      add_test_result($lr_template->id,'Hb',113,'','',1,1);
      add_test_result($lr_template->id,'HCT',38,'','',1,1);
      add_test_result($lr_template->id,'RBC',49,'','',1,1);
      add_test_result($lr_template->id,'MCV',72,'','',1,1);
      add_test_result($lr_template->id,'MCH',39,'','',1,1);
      add_test_result($lr_template->id,'Szybki',312,'','',1,1);
      add_test_result($lr_template->id,'Średni',150,'','',1,1);
      add_test_result($lr_template->id,'Wolny',150,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'pomarańczowy','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);

      $lr_template = new LabOrderTemplate();
      $lr_template->actor_id    = $actor->id;
      $lr_template->description_for_leader = 'dzisiajesze wyniki';
      $lr_template->lrt_minutes_before = 32; // sprzed 32 minut
      $lr_template->lrt_type    = 2;
      $lr_template->lrt_sort    = 2;
      $lr_template->save();

      add_test_result($lr_template->id,'Hb',109,'','',2,1);
      add_test_result($lr_template->id,'HCT',375,'','',2,1);
      add_test_result($lr_template->id,'RBC',48,'','',2,1);
      add_test_result($lr_template->id,'MCV',80,'','',2,1);
      add_test_result($lr_template->id,'MCH',34,'','',2,1);
      add_test_result($lr_template->id,'Szybki',312,'','',1,1);
      add_test_result($lr_template->id,'Średni',150,'','',1,1);
      add_test_result($lr_template->id,'Wolny',150,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'pomarańczowy','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);

      $lr_template = new LabOrderTemplate();
      $lr_template->actor_id    = $actor->id;
      $lr_template->description_for_leader = 'bieżące wyniki po podaniu wapnia';
      $lr_template->lrt_minutes_before = 0;
      $lr_template->lrt_type    = 2;
      $lr_template->lrt_sort    = 2;
      $lr_template->save();

      add_test_result($lr_template->id,'Hb',129,'','',2,1);
      add_test_result($lr_template->id,'HCT',325,'','',2,1);
      add_test_result($lr_template->id,'RBC',43,'','',2,1);
      add_test_result($lr_template->id,'MCV',60,'','',2,1);
      add_test_result($lr_template->id,'MCH',28,'','',2,1);
      add_test_result($lr_template->id,'Szybki',312,'','',1,1);
      add_test_result($lr_template->id,'Średni',150,'','',1,1);
      add_test_result($lr_template->id,'Wolny',150,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'pomarańczowy','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);

      $lr_template = new LabOrderTemplate();
      $lr_template->actor_id    = $actor->id;
      $lr_template->description_for_leader = 'bieżące wyniki bez podania wapnia';
      $lr_template->lrt_minutes_before = 0;
      $lr_template->lrt_type    = 2;
      $lr_template->lrt_sort    = 2;
      $lr_template->save();

      add_test_result($lr_template->id,'Hb',99,'','',2,1);
      add_test_result($lr_template->id,'HCT',447,'','',2,1);
      add_test_result($lr_template->id,'RBC',33,'','',2,1);
      add_test_result($lr_template->id,'MCV',72,'','',2,1);
      add_test_result($lr_template->id,'MCH',39,'','',2,1);
      add_test_result($lr_template->id,'Szybki',312,'','',1,1);
      add_test_result($lr_template->id,'Średni',150,'','',1,1);
      add_test_result($lr_template->id,'Wolny',150,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'pomarańczowy','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);


      // ####################################################################################



      // ####################################################################################

      $scenario = new Scenario();
      $scenario->scenario_author_id = null;
      // $scenario->scenario_author_id = \App\Models\User::where('name','instruktor')->first()->id;
      $actor->actor_incoming_recalculate      = 0;
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
      $actor->actor_incoming_recalculate      = 0;
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
      $actor->actor_incoming_recalculate      = 0;
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
      $actor->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
      $actor->actor_incoming_recalculate      = 0;
      $actor->actor_age_from      = 0;
      $actor->actor_age_to        = 0;
      $actor->actor_age_interval  = 1;  // 1 - lata,  2 - miesiąca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $actor->actor_sex           = 2;  // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
      $actor->actor_role_plan_id  = \App\Models\ActorRolePlan::where('short','drugoplanowa')->first()->id;
      $actor->actor_role_name     = 'Noworodek - 0 dni';
      $actor->actor_type_id       = \App\Models\ActorType::where('short','PAC STAND')->first()->id;
      $actor->history_for_actor   = 'Dzisiaj urodzony :)';
      $actor->actor_simulation = "opis dziś urodzonego noworodka";
      $actor->actor_status = 1;
      $actor->save();	

      $actor = new Actor();
      $actor->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
      $actor->actor_incoming_recalculate      = 0;
      $actor->actor_age_from      = 0;
      $actor->actor_age_to        = 30;
      $actor->actor_age_interval  = 1;  // 1 - lata,  2 - miesiąca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $actor->actor_sex           = 2;  // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
      $actor->actor_role_plan_id  = \App\Models\ActorRolePlan::where('short','drugoplanowa')->first()->id;
      $actor->actor_role_name     = 'Noworodek';
      $actor->actor_type_id       = \App\Models\ActorType::where('short','PAC STAND')->first()->id;
      $actor->history_for_actor   = 'Niedawno urodzony :)';
      $actor->actor_simulation = "opis noworodka.";
      $actor->actor_status = 1;
      $actor->save();	

      $actor = new Actor();
      $actor->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
      $actor->actor_incoming_recalculate      = 0;
      $actor->actor_age_from      = 3;
      $actor->actor_age_to        = 5;
      $actor->actor_age_interval  = 1;  // 1 - lata,  2 - miesiąca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $actor->actor_sex           = 2;  // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
      $actor->actor_role_plan_id  = \App\Models\ActorRolePlan::where('short','drugoplanowa')->first()->id;
      $actor->actor_role_name     = 'Przedszkolak';
      $actor->actor_type_id       = \App\Models\ActorType::where('short','PAC STAND')->first()->id;
      $actor->history_for_actor   = 'Sprytny przedszkolaczek';
      $actor->actor_simulation = "Umorusany czekoladą";
      $actor->actor_status = 1;
      $actor->save();	


    }
}
