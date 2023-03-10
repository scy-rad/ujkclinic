<?php
//php artisan db:seed --class=ScenariosSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Scenario;
use App\Models\Character;
use App\Models\LabOrderTemplate;
use App\Models\LabResultTemplate;
use App\Models\ScenarioConsultationTemplate;
use App\Models\ScenarioConsultationTemplateAttachment;
use App\Models\SceneType;
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
      ScenarioConsultationTemplateAttachment::truncate();
      ScenarioConsultationTemplate::truncate();
      LabResultTemplate::truncate();
      LabOrderTemplate::truncate();
      Character::truncate();
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

     
      $hospital_scene = SceneType::where('scene_type_code','hospital')->first()->id;
      $medical_center_scene = SceneType::where('scene_type_code','medical_center')->first()->id;
      

      $scenario = new Scenario();
      // $scenario->scenario_author_id = null;
      $scenario->scenario_author_id = \App\Models\User::where('name','instruktor')->first()->id;
      $scenario->center_id        =  \App\Models\Center::where('center_short','Piel')->first()->id;
      $scenario->scenario_type_id =  \App\Models\ScenarioType::where('short','sym')->first()->id;
      $scenario->scene_type_id    =  $hospital_scene;
      $scenario->scenario_name  = 'niedokrwisto????';
      $scenario->scenario_code  = 'ZK-HEM-01';
      $scenario->scenario_main_problem = '';
      $scenario->scenario_description = 'Pacjentka przetransportowana przez ZRM do SOR zg??asza utrat?? przytomno??ci, duszno????, zawroty g??owy, zwi??kszon?? m??czliwo????. Po zebraniu wywiadu grupa powinna wykluczy?? mo??liwe przyczyny zg??aszanych objaw??w takie jak ponowny zawa?? serca, zatorowo???? p??ucna, ostre choroby uk??adu oddechowego oraz ukierunkowa?? swoje podejrzenia na niedokrwisto????. Zaplanowa?? wst??pn?? diagnostyk?? r????nicow?? niedokrwisto??ci, wykona?? podstawowe badania pomocnicze (morfologia krwi obwodowej, parametry gospodarki ??elazowej, ewentualne badania obrazowe przewodu pokarmowego dost??pne na SOR), w????czy?? konieczne leczenie (w sytuacji konieczno??ci przygotowanie do zam??wienia, zam??wienie i przetoczenie KKCz, lub skierowanie na oddzia?? wewn??trzny celem przetoczenia sk??adnik??w krwi i dalszej diagnostyki)';
      $scenario->scenario_for_students = '70-letnia kobieta zosta??a przetransportowana do SOR  przez ZRM z powodu utraty przytomno??ci, podczas spaceru.';
      $scenario->scenario_for_leader  = '<p>
      <b>G????wne dolegliwo??ci</b>: Utrata przytomno??ci, duszno????, b??le i zawroty g??owy, os??abienie i ??atwa m??czliwo????<br>
      <b>Dotychczasowy przebieg choroby</b>: Od miesi??ca odczuwa nasilaj??c?? si?? m??czliwo????, musi odpoczywa?? jak wchodzi po schodach. B??le brzucha nasilaj??ce si?? na czczo, ust??puj??ce po spo??yciu pokarmu.<br>
      <b>Choroby przewlek??e</b>: Przebyty STEMI ??ciany dolnej 6 lat temu powik??any niedomykalno??ci?? zastawki mitralnej, nadci??nienie t??tnicze od 20 lat, mia??d??yca, przewlek??e b??le kr??gos??upa.<br>
      <b>Leki</b>: Acard 75mg/d; Bibloc 10mg/d; Lisiprol 20mg/d; Atoris 10mg/d; Ibalgin MAXI dora??nie<br>
      <b>Zabiegi operacyjne</b>: Angioplastyka naczy?? wie??cowych z wszczepieniem DES 6 lat temu, usuni??ty p??cherzyk z????ciowy 15 lat temu.<br>
      <b>Uczulenia</b>: neguje<br>
      <b>Na??ogi</b>: tyto?? - neguje; alkohol - okazjonalnie<br>
      <b>Wywiad rodzinny</b>: ojciec rak jelita grubego, matka cukrzyca, nadci??nienie t??tnicze, nowotw??r ??e??skich narz??d??w rodnych. <br>
      <b>Wywiad spo??eczny</b>: emerytka, mieszka z m????em
      </p>';
      $scenario->scenario_helpers_for_students= '';
      $scenario->scenario_logs_for_students   = '';
      $scenario->scenario_status	= 1;
      $scenario->save();

      $character = new Character();
      $character->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','PIEL-INT-PED-01')->first()->id;
      $character->character_incoming_recalculate      = 0;
      $character->character_age_from      = 65;
      $character->character_age_to        = 78;
      $character->character_age_interval  = 1;  // 1 - lata,  2 - miesi??ca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $character->character_sex           = 3;  // 1 - nieistotna,  2 - m????czyzna,  3 - kobieta
      $character->character_role_plan_id  = \App\Models\CharacterRolePlan::where('short','pierwszoplanowa')->first()->id;
      $character->character_role_name     = 'Kobieta z niedokrwisto??ci??';
      $character->character_type_id       = \App\Models\CharacterType::where('short','SYM WW')->first()->id;
      $character->history_for_actor   = 'Zg??aszasz utrat?? przytomno??ci, duszno????, zawroty g??owy, zwi??kszon?? m??czliwo????. Nie mia??a?? wcze??niej problem??w z sercem.';
      $character->character_simulation = "Starsza kobieta";
      $character->character_status = 1;
      $character->save();	


      $lr_template = new LabOrderTemplate();
      $lr_template->character_id    = $character->id;
      $lr_template->description_for_leader = 'wyniki bada?? z SOR';
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
add_test_result($lr_template->id,'S??D','142','','',1,1);
add_test_result($lr_template->id,'Chlorki','101','','',1,1);
add_test_result($lr_template->id,'FOSFOR','92','','',1,1);
add_test_result($lr_template->id,'WAP?? ca??kowity','25','','',1,1);

add_test_result($lr_template->id,'AlAT','32','','',1,1);
add_test_result($lr_template->id,'AspAT','21','','',1,1);

add_test_result($lr_template->id,'BILIRUBINA','8','','',1,1);
add_test_result($lr_template->id,'AMYLAZA','270','','',1,1);

add_test_result($lr_template->id,'CK','201','','',1,1);



add_test_result($lr_template->id,'pH (BOM)','55','','',1,1);
add_test_result($lr_template->id,'ci????ar_w??a??ciwy','1030','','',1,1);
add_test_result($lr_template->id,'kolor','0','??????ty','',1,1);
add_test_result($lr_template->id,'bia??ko (BOM)','0','nieobecne','',1,1);
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
add_test_result($lr_template->id,'S??D','142','','',1,1);
add_test_result($lr_template->id,'CHLORki','101','','',1,1);
add_test_result($lr_template->id,'FOSFOR','92','','',1,1);


add_test_result($lr_template->id,'AlAT','32','','',1,1);
add_test_result($lr_template->id,'AspAT','21','','',1,1);


add_test_result($lr_template->id,'AMYLAZA','270','','',1,1);

add_test_result($lr_template->id,'CK','201','','',1,1);


$sc_template = new ScenarioConsultationTemplate();
$sc_template->character_id    = $character->id;
$sc_template->sct_name = 'szablon wynik??w rtg klatki piersiowej';
$sc_template->sct_seconds_description = 60*9+22;  //9 minut i 22 sekundy
$sc_template->sct_verbal_attach    = 'Nic niepokoj??cego tu nie wida??, ale to jeszcze musi lekarz to sprawdzi?? i opisa??';
$sc_template->sct_description    = 'Obraz p??uc prawid??owy. W okolicy kr??gu L5 widoczne niewielkie zacienienie, mog??ce sugerowa?? obecno???? obcej masy litej. Wskazana dalsza diagnostyka.';
$sc_template->save();

$sct_attachment = new ScenarioConsultationTemplateAttachment();
$sct_attachment->sct_id = $sc_template->id;
$sct_attachment->scta_file = '/storage/simulations/character/rtg_001.jpg';
$sct_attachment->scta_type = 'img';
$sct_attachment->scta_name = 'RTG klatki piersiowej';
$sct_attachment->scta_seconds_attachments = 0;
$sct_attachment->save();

$sc_template = new ScenarioConsultationTemplate();
$sc_template->character_id    = $character->id;
$sc_template->sct_name = 'szablon wynik??w rtg d??oni';
$sc_template->sct_seconds_description = 60*10+2;  //10 minut i 2 sekundy
$sc_template->sct_verbal_attach    = 'R??ce jak r??ce - obie i to do pary';
$sc_template->sct_description    = 'Na pierwszy rzut oka wydawa?? by si?? mog??o, ??e obraz jest prawid??owy (bo tak jest), ale moje wprawne oko stwierdza, ??e do pracy to s?? to dwie lewe r??ce.';
$sc_template->save();

$sct_attachment = new ScenarioConsultationTemplateAttachment();
$sct_attachment->sct_id = $sc_template->id;
$sct_attachment->scta_file = '/storage/simulations/character/rtg_002.jpg';
$sct_attachment->scta_type = 'img';
$sct_attachment->scta_name = 'RTG klatki piersiowej';
$sct_attachment->scta_seconds_attachments = 0;
$sct_attachment->save();

$sc_template = new ScenarioConsultationTemplate();
$sc_template->character_id    = $character->id;
$sc_template->sct_name = 'szablon wynik??w USG jamy brzusznej';
$sc_template->sct_seconds_description = 60*8+12;  //8 minut i 12 sekundy
$sc_template->sct_verbal_attach    = 'Dokor musi to oceni??';
$sc_template->sct_description    = 'Galia est omnis divisa in partes tres. Quarum unam incolunt Belgae aliam Aquitani.';
$sc_template->save();

$sct_attachment = new ScenarioConsultationTemplateAttachment();
$sct_attachment->sct_id = $sc_template->id;
$sct_attachment->scta_file = '/storage/simulations/character/usg_001.jpg';
$sct_attachment->scta_type = 'img';
$sct_attachment->scta_name = '';
$sct_attachment->scta_seconds_attachments = 0;
$sct_attachment->save();

$sct_attachment = new ScenarioConsultationTemplateAttachment();
$sct_attachment->sct_id = $sc_template->id;
$sct_attachment->scta_file = '/storage/simulations/character/usg_002.jpg';
$sct_attachment->scta_type = 'img';
$sct_attachment->scta_name = '';
$sct_attachment->scta_seconds_attachments = 0;
$sct_attachment->save();

$sct_attachment = new ScenarioConsultationTemplateAttachment();
$sct_attachment->sct_id = $sc_template->id;
$sct_attachment->scta_file = '/storage/simulations/character/usg_003.jpg';
$sct_attachment->scta_type = 'img';
$sct_attachment->scta_name = '';
$sct_attachment->scta_seconds_attachments = 0;
$sct_attachment->save();


      $scenario = new Scenario();
      // $scenario->scenario_author_id = null;
      $scenario->scenario_author_id = \App\Models\User::where('name','instruktor')->first()->id;
      $scenario->center_id        =  \App\Models\Center::where('center_short','Piel')->first()->id;
      $scenario->scenario_type_id =  \App\Models\ScenarioType::where('short','sym')->first()->id;
      $scenario->scene_type_id    =  $hospital_scene;
      $scenario->scenario_name  = 'scenariusz testowy pierwszy';
      $scenario->scenario_code  = 'PIEL-INT-PED-01';
      $scenario->scenario_main_problem = 'Oddzia?? pediatryczny';
      $scenario->scenario_description = 'Dziecko przewr??ci??o si?? na rowerze i dozna??o z??amania otwartego r??ki z ran?? ci??t?? skroni. Na oddziale jest ju?? dw??jka innych dzieci';
      $scenario->scenario_for_students = 'Jeste??cie lekarzami na Izbie Przyj????. ZRM przywiezie Wam p????przytomne dziecko, kt??re zostalo potr??cone przez pijanego kierowc?? samochodu. Wynki bada?? z karetki powinny by?? ju?? dost??pne w systemie szpitalnym.';
      $scenario->scenario_for_leader  = 'Dziecko choruje na cukrzyc?? i w trakcie transportu na Izb?? Przyj???? cukier znacznie spad?? (czego nie wida?? w wynikach z karetki';
      $scenario->scenario_helpers_for_students= '<ul><li>je??li zesp???? nie powi????e pogarszania si?? stanu dziecka z cukrzyc??, mo??e zadzwoni?? mama z t?? informacj??</li></ul>';
      $scenario->scenario_logs_for_students   = '<ul><li>n sal?? mo??e wej???? pijany kierowca, kt??y potr??c?? dziecko, a teraz chce je stamt??d zabra??, bo wszystko jest w porz??dku i on wszystko za??atwi z rodzicami dziecka.</li></ul>';
      $scenario->scenario_status	= 1;
      $scenario->save();

      $character = new Character();
      $character->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','PIEL-INT-PED-01')->first()->id;
      $character->character_incoming_recalculate      = 0;
      $character->character_age_from      = 11;
      $character->character_age_to        = 15;
      $character->character_age_interval  = 1;  // 1 - lata,  2 - miesi??ca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $character->character_sex           = 1;  // 1 - nieistotna,  2 - m????czyzna,  3 - kobieta
      $character->character_role_plan_id  = \App\Models\CharacterRolePlan::where('short','pierwszoplanowa')->first()->id;
      $character->character_role_name     = 'poszkodowane dziecko';
      $character->character_type_id       = \App\Models\CharacterType::where('short','SYM WW')->first()->id;
      $character->history_for_actor   = 'Dziecko na pocz??tku jest w s??abym kontakcie, po chwili ca??kowicie traci przytomno??c z powodu spadku cukru';
      $character->character_simulation = "Pacjent z zadrapaniami na twarzy i r??kach. Mo??e mie?? z??amanie lub opatrunek uciskowy na ko??czynie";
      $character->character_status = 1;
      $character->save();	

      $lr_template = new LabOrderTemplate();
      $lr_template->character_id    = $character->id;
      $lr_template->description_for_leader = 'wyniki bada?? z wizyty w poradni dzie?? wcze??niej';
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
      add_test_result($lr_template->id,'??redni',150,'','',1,1);
      add_test_result($lr_template->id,'Wolny',150,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'zielony','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);

      $lr_template = new LabOrderTemplate();
      $lr_template->character_id    = $character->id;
      $lr_template->description_for_leader = 'szablon wynik??w z Izby Przyj????';
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
      add_test_result($lr_template->id,'??redni',149,'','',1,1);
      add_test_result($lr_template->id,'Wolny',149,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'pomara??czowy','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);

      $character = new Character();
      $character->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','PIEL-INT-PED-01')->first()->id;
      $character->character_incoming_recalculate      = 24*60*2+188; // 2 dni 3 godz i 8 minut wcze??niej
      $character->character_age_from      = 7;
      $character->character_age_to        = 7;
      $character->character_age_interval  = 4;  // 1 - lata,  2 - miesi??ca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $character->character_sex           = 1;  // 1 - nieistotna,  2 - m????czyzna,  3 - kobieta
      $character->character_role_plan_id  = \App\Models\CharacterRolePlan::where('short','pierwszoplanowa')->first()->id;
      $character->character_role_name     = 'tygodniowy noworodek';
      $character->character_type_id       = \App\Models\CharacterType::where('short','MAN')->first()->id;
      $character->history_for_actor   = 'Dziecko le??y i czasami pop??akuje';
      $character->character_simulation = "Je??li dziecko by??oby istotne z punktu widzenia symulacji - to tu by??oby o tym napisane";
      $character->character_status = 1;
      $character->save();	

      $lr_template = new LabOrderTemplate();
      $lr_template->character_id    = $character->id;
      $lr_template->description_for_leader = 'wyniki bada?? z przyj??cia';
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
      add_test_result($lr_template->id,'??redni',150,'','',1,1);
      add_test_result($lr_template->id,'Wolny',150,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'pomara??czowy','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);

      $lr_template = new LabOrderTemplate();
      $lr_template->character_id    = $character->id;
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
      add_test_result($lr_template->id,'??redni',150,'','',1,1);
      add_test_result($lr_template->id,'Wolny',150,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'pomara??czowy','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);

      $lr_template = new LabOrderTemplate();
      $lr_template->character_id    = $character->id;
      $lr_template->description_for_leader = 'bie????ce wyniki po podaniu wapnia';
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
      add_test_result($lr_template->id,'??redni',150,'','',1,1);
      add_test_result($lr_template->id,'Wolny',150,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'pomara??czowy','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);

      $lr_template = new LabOrderTemplate();
      $lr_template->character_id    = $character->id;
      $lr_template->description_for_leader = 'bie????ce wyniki bez podania wapnia';
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
      add_test_result($lr_template->id,'??redni',150,'','',1,1);
      add_test_result($lr_template->id,'Wolny',150,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'pomara??czowy','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);


      // ####################################################################################



      // ####################################################################################

      $scenario = new Scenario();
      // $scenario->scenario_author_id = null;
      $scenario->scenario_author_id = \App\Models\User::where('name','instruktor')->first()->id;
      $scenario->center_id        =  \App\Models\Center::where('center_short','Lek')->first()->id;
      $scenario->scenario_type_id =  \App\Models\ScenarioType::where('short','sym')->first()->id;
      $scenario->scene_type_id    =  $medical_center_scene;
      $scenario->scenario_name  = 'InsulinoODporno????';
      $scenario->scenario_code  = 'KP-RODZ-01';
      $scenario->scenario_main_problem = 'Oty??o???? spowodowana inulinooporno??ci??';
      $scenario->scenario_description = '<p>Wizyta lekarska w POZ</p>';
      $scenario->scenario_for_students = '<p>Jeste?? internist?? w Przychodni POZ</p>';
      $scenario->scenario_for_leader  = '<p><strong>Istotne kwestie do om??wienia w debriefingu:</strong>
        Czym jest i czym nie jest insulinooporno????, jak wygl??da OGTT i do czego s??u??y, do czego s??u??y HOMA-IR, czy powinno si?? leczy?? insulinooporno???? poza PCOS, kiedy PCOS szuka??, jak leczy?? ewentualnie, jak zach??ca?? do MS??.</p> 
        <p><strong>Rzetelny artyku??:</strong> <a href="https://www.mp.pl/endokrynologia/ekspert/288739,insulinoopornosc-jako-pseudochoroba-powszechny-problem-w-gabinecie-diabetologa-i-endokrynologa,1">https://www.mp.pl/endokrynologia/ekspert/288739,insulinoopornosc-jako-pseudochoroba-powszechny-problem-w-gabinecie-diabetologa-i-endokrynologa,1</a>';
      $scenario->scenario_helpers_for_students= '';
      $scenario->scenario_logs_for_students   = '';
      $scenario->scenario_status	= 1;
      $scenario->save();

      $character = new Character();
      $character->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','PIEL-INT-PED-01')->first()->id;
      $character->character_incoming_recalculate      = 0;
      $character->character_age_from      = 33;
      $character->character_age_to        = 39;
      $character->character_age_interval  = 1;  // 1 - lata,  2 - miesi??ca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $character->character_sex           = 3;  // 1 - nieistotna,  2 - m????czyzna,  3 - kobieta
      $character->character_role_plan_id  = \App\Models\CharacterRolePlan::where('short','pierwszoplanowa')->first()->id;
      $character->character_role_name     = 'kobieta z insulinooporno??ci??';
      $character->character_type_id       = \App\Models\CharacterType::where('short','PAC STAND')->first()->id;
      $character->history_for_actor   = '<p><strong>G????wna dolegliwo????:</strong> Zg??aszasz si??, przej??ta, do gabinetu lekarza rodzinnego, po tym jak na w??asn?? r??k?? (tw??j pomys?? ginekolog okre??li?? jako bardzo dobry) wykona??a?? sobie test tolerancji glukozy (???krzyw?? cukrow?? i insulinow?????) z oznaczeniami insuliny ??? wynik masz przy sobie. Sprawdza??a?? ju?? w internecie, konsultowa??a?? si?? z ginekologiem i rozpoznanie jest jedno ??? ci????ka insulinoODporno???? (profesjonalnie ten stan nazywa si?? insulinooporno??ci??, ale pacjentka, jak?? chc?? tutaj przedstawi?? celowo powinna to s??owo przekr??ca??). Jeste?? bardzo przej??ta tym wynikiem, uwa??asz, ??e w ko??cu znalaz??a?? przyczyn??, kt??ra nie pozwala Ci schudn???? (wa??ne!).</p>
      <p><strong>Styl ??ycia i oty??o????:</strong> W swoim ??yciu kilkukrotnie pr??bowa??a?? chudn????, z niewielkimi efektami. Obecna waga mie??ci si?? w kryterium nadwagi/oty??o??ci I stopnia. Nie palisz i nigdy nie pali??a??. Alkohol pijesz sporadycznie. Nie uprawiasz ??adnego sportu ??? jedynie spacery, zakupy, itp.</p>
      <p><strong>Ginekologicznie:</strong> Rodzi??a?? 2x, masz dw??jk?? zdrowych dzieci, c??rk?? 5 lat i syna 9 lat. Cykle s?? regularne, miesi??czki umiarkowanie bolesne. W USG przezpochwowym ginekolog nie stwierdzi?? odchyle??.</p>
      <p><strong>Przewlekle:</strong> Nie leczysz si?? na sta??e, okresowo bierzesz suplementy takie jak Novophane na w??osy, selen, cynk, witamina D.</p>
      <p><strong>W badaniu:</strong> Bez istotnych odchyle??, pr??cz nadwagi/oty??o??ci (jako?? to zrobimy).</p>
      <p><strong>Nastawienie:</strong> Jeste?? przekonana, o tym, ??e insulinoodporno???? to powa??na choroba. Je??li student b??dzie zaczyna?? temat modyfikacji stylu ??ycia jeste?? niech??tna ???bo ju?? tyle razy pr??bowa??am, cz??owiek z dw??jk?? dzieci, gdzie ja czas znajd?????. Nalegasz na wypisanie ???jakich?? tabletek???. Je??li student jasno uargumentuje co to za choroba, ??e jest skutkiem oty??o??ci a nie przyczyn??, powoli zaczynasz si?? przekonywa?? do proponowanego leczenia.</p>';
      $character->character_simulation = "Wskazana nadwaga/oty??o???? pacjenta";
      $character->character_status = 1;
      $character->save();	

      $lr_template = new LabOrderTemplate();
      $lr_template->character_id    = $character->id;
      $lr_template->description_for_leader = 'wyniki bada?? sprzed 5 dni';
      $lr_template->lrt_minutes_before = 5*60*24-66;  //24 godziny wczesniej bez 66 minut
      $lr_template->lrt_type    = 1;
      $lr_template->lrt_sort    = 1;
      $lr_template->save();

      add_test_result($lr_template->id,'Hb',113,'','',1,1);
      add_test_result($lr_template->id,'HCT',38,'','',1,1);
      add_test_result($lr_template->id,'RBC',49,'','',1,1);
      add_test_result($lr_template->id,'MCV',72,'','',1,1);
      add_test_result($lr_template->id,'MCH',39,'','',1,1);
      add_test_result($lr_template->id,'Szybki',312,'','',1,1);
      add_test_result($lr_template->id,'??redni',150,'','',1,1);
      add_test_result($lr_template->id,'Wolny',150,'','',1,1);
      add_test_result($lr_template->id,'Opis',null,'zielony','',1,1);
      add_test_result($lr_template->id,'Minus',-21,'','',1,1);

      // ####################################################################################



      // ####################################################################################

      $scenario = new Scenario();
      $scenario->scenario_author_id = null;
      // $scenario->scenario_author_id = \App\Models\User::where('name','instruktor')->first()->id;
      $character->character_incoming_recalculate      = 0;
      $scenario->center_id        =  \App\Models\Center::where('center_short','Lek')->first()->id;
      $scenario->scenario_type_id =  \App\Models\ScenarioType::where('short','sym')->first()->id;
      $scenario->scene_type_id    =  $hospital_scene;
      $scenario->scenario_name  = 'scenariusz testowy drugi';
      $scenario->scenario_code  = 'LEK-INT-PED-01';
      $scenario->scenario_main_problem = 'z??amanie otwarte nogi, wstrz????nienie m??zgu';
      $scenario->scenario_description = 'ch??opczyk przewr??ci?? si?? na rowerze i dozna?? z??amania otwartego r??ki z ran?? ci??t?? skroni. Podejrzenie wstrz????nienia m??zgu.';
      $scenario->scenario_for_students = 'Jeste??cie lekarzami na Izbie Przyj????. ZRM przywi??z?? Wam pacjenta/k?? (kierowc??) z wypadku samochodowego, u kt??rego/ej nast??pi??o zatrzymanie kr????enia. Kr????enie wr??ci??o w karetce.';
      $scenario->scenario_for_leader  = 'Poszkodowany zosta?? przywieziony nieprawid??owo zaintubowany.';
      $scenario->scenario_helpers_for_students= '<ul><li>Zabranie dystraktora na badania obrazowe</li></ul>';
      $scenario->scenario_logs_for_students   = '<ul><li>Dystraktor odbiera telefon od ??ony poszkodowanego i zaczyna si?? zo??ci?? i g??o??no zachowywa?? nie daj??c si?? uciszy??</li></ul>';
      $scenario->scenario_status	= 1;
      $scenario->save();

      $character = new Character();
      $character->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
      $character->character_incoming_recalculate      = 0;
      $character->character_age_from      = 48;
      $character->character_age_to        = 68;
      $character->character_age_interval  = 1;  // 1 - lata,  2 - miesi??ca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $character->character_sex           = 2;  // 1 - nieistotna,  2 - m????czyzna,  3 - kobieta
      $character->character_role_plan_id  = \App\Models\CharacterRolePlan::where('short','pierwszoplanowa')->first()->id;
      $character->character_role_name     = 'pacjent';
      $character->character_type_id       = \App\Models\CharacterType::where('short','SYM WW')->first()->id;
      $character->history_for_actor   = 'Pacjent przez ca??y czas jest nieprzytomny';
      $character->character_simulation = "Pacjent z naklejonymi ranami ci??tymi, z nieprawid??owo za??o??on?? rurk?? intubacyjn??, z za??o??onym wk??uciem obwodowym";
      $character->character_status = 1;
      $character->save();	

      

      $character = new Character();
      $character->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
      $character->character_incoming_recalculate      = 0;
      $character->character_age_from      = 42;
      $character->character_age_to        = 60;
      $character->character_age_interval  = 1;  // 1 - lata,  2 - miesi??ca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $character->character_sex           = 2;  // 1 - nieistotna,  2 - m????czyzna,  3 - kobieta
      $character->character_role_plan_id  = \App\Models\CharacterRolePlan::where('short','drugoplanowa')->first()->id;
      $character->character_role_name     = 'kolega poszkodowanego';
      $character->character_type_id       = \App\Models\CharacterType::where('short','PAC STAND')->first()->id;
      $character->history_for_actor   = 'Jeste?? koleg?? poszkodowanego. Wracali??cie z imprezy firmowej, na kt??rej by??o sporo alkoholu, ale zapewniasz, ??e kierowca nie pi??. Ty jeste?? pijany i zachowujesz si?? g??o??no, martwi??c si?? o stan kolegi. Nie jeste?? agresywny, ale do???? natr??tny. Jak Ci?? uciszaj?? przepraszasz i siadasz na le??ance, ale po chwili znowu podchodzisz i g??o??nio si?? zwracasz do lekarzy lub nieprzytomnego kolegi.';
      $character->character_simulation = "Pacjent z siniakiem na g??owie, mo??e mie?? te?? ma???? ran??. Mocno wyczuwalna wo?? alkoholu.";
      $character->character_status = 1;
      $character->save();	

      $character = new Character();
      $character->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
      $character->character_incoming_recalculate      = 0;
      $character->character_age_from      = 0;
      $character->character_age_to        = 0;
      $character->character_age_interval  = 1;  // 1 - lata,  2 - miesi??ca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $character->character_sex           = 2;  // 1 - nieistotna,  2 - m????czyzna,  3 - kobieta
      $character->character_role_plan_id  = \App\Models\CharacterRolePlan::where('short','drugoplanowa')->first()->id;
      $character->character_role_name     = 'Noworodek - 0 dni';
      $character->character_type_id       = \App\Models\CharacterType::where('short','PAC STAND')->first()->id;
      $character->history_for_actor   = 'Dzisiaj urodzony :)';
      $character->character_simulation = "opis dzi?? urodzonego noworodka";
      $character->character_status = 1;
      $character->save();	

      $character = new Character();
      $character->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
      $character->character_incoming_recalculate      = 0;
      $character->character_age_from      = 0;
      $character->character_age_to        = 30;
      $character->character_age_interval  = 1;  // 1 - lata,  2 - miesi??ca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $character->character_sex           = 2;  // 1 - nieistotna,  2 - m????czyzna,  3 - kobieta
      $character->character_role_plan_id  = \App\Models\CharacterRolePlan::where('short','drugoplanowa')->first()->id;
      $character->character_role_name     = 'Noworodek';
      $character->character_type_id       = \App\Models\CharacterType::where('short','PAC STAND')->first()->id;
      $character->history_for_actor   = 'Niedawno urodzony :)';
      $character->character_simulation = "opis noworodka.";
      $character->character_status = 1;
      $character->save();	

      $character = new Character();
      $character->scenario_id         = $scenario->id; //\App\Models\Scenario::where('scenario_code','LEK-INT-PED-01')->first()->id;
      $character->character_incoming_recalculate      = 0;
      $character->character_age_from      = 3;
      $character->character_age_to        = 5;
      $character->character_age_interval  = 1;  // 1 - lata,  2 - miesi??ca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
      $character->character_sex           = 2;  // 1 - nieistotna,  2 - m????czyzna,  3 - kobieta
      $character->character_role_plan_id  = \App\Models\CharacterRolePlan::where('short','drugoplanowa')->first()->id;
      $character->character_role_name     = 'Przedszkolak';
      $character->character_type_id       = \App\Models\CharacterType::where('short','PAC STAND')->first()->id;
      $character->history_for_actor   = 'Sprytny przedszkolaczek';
      $character->character_simulation = "Umorusany czekolad??";
      $character->character_status = 1;
      $character->save();	


    }
}
