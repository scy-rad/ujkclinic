<?php
//php artisan db:seed --class=LaboratoryNormsSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use App\Models\LaboratoryTestGroup;
use App\Models\LaboratoryTest;
use App\Models\LaboratoryTestNorm;

class LaboratoryNormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      Schema::disableForeignKeyConstraints();
      LaboratoryTestNorm::truncate();
      LaboratoryTest::truncate();
      LaboratoryTestGroup::truncate();
      Schema::enableForeignKeyConstraints();

      function insert_ltg($data_row)
      {
        $tab=explode(";",$data_row);
        $table = new LaboratoryTestGroup();
        $table->ltg_name = $tab[0];
        $table->ltg_name_en = $tab[1];
        $table->ltg_levels_count = $tab[2];
        $table->ltg_sort = $tab[3];
        $table->save();
      } 
      function insert_lt($data_row)
      {
        $tab=explode(";",$data_row);
        $ltg_id=LaboratoryTestGroup::where('ltg_name',$tab[0])->first()->id;
        $table = new LaboratoryTest();
        $table->laboratory_test_group_id = $ltg_id;
        $table->lt_name = $tab[1];
        $table->lt_name_en = $tab[2];
        $table->lt_short = $tab[3];
        $table->lt_short_en = $tab[4];
        $table->lt_result_type = $tab[5];
        $table->lt_level = $tab[6];
        $table->lt_sort = $tab[7];
        $table->lt_time = $tab[8];
        $table->lt_coast = $tab[9];
        $table->lt_time_cito = $tab[10];
        $table->lt_coast_cito = $tab[11];
        $table->save();

      } 
      function insert_ltn($data_row)
      {
        $tab=explode(";",str_replace(',','.',$data_row));
        // echo $tab[0]."\n";
        $lt_id=LaboratoryTest::where('lt_name',$tab[0])->first()->id;
        $table = new LaboratoryTestNorm();
        $table->laboratory_test_id = $lt_id;
        $table->ltn_days_from = $tab[1];
        $table->ltn_days_to = $tab[2];
        $table->ltn_norm_type = $tab[3];

        if ($tab[4] == '') $table->ltn_norm_m_min = null;  else $table->ltn_norm_m_min = $tab[4]*$tab[12];
        if ($tab[5] == '') $table->ltn_norm_m_max = null;  else $table->ltn_norm_m_max = $tab[5]*$tab[12];
        if ($tab[6] == '') $table->ltn_norm_w_min = null;  else $table->ltn_norm_w_min = $tab[6]*$tab[12];
        if ($tab[7] == '') $table->ltn_norm_w_max = null;  else $table->ltn_norm_w_max = $tab[7]*$tab[12];
        if ($tab[8] == '') $table->ltn_norm_p_min = null;  else $table->ltn_norm_p_min = $tab[8]*$tab[12];
        if ($tab[9] == '') $table->ltn_norm_p_max = null;  else $table->ltn_norm_p_max = $tab[9]*$tab[12];

        $table->ltn_unit = $tab[10];
        $table->ltn_unit_en = $tab[11];
        $table->ltn_decimal_prec = $tab[12];
        $table->save();

      }

      insert_ltg("Morfologia krwi;EN_Morfologia krwi;1;1");	insert_lt("Morfologia krwi;Hemoglobina;EN_Hemoglobina;Hb;HBL;1;1;1;5;250;3;350");	insert_ltn("Hemoglobina;0;14;3;13,9;19,1;13,4;20;13,4;20;g/dl;g/dl;10");
      insert_ltn("Hemoglobina;15;30;3;10;15,3;10,8;14,6;10,8;14,6;g/dl;g/dl;10");
      insert_ltn("Hemoglobina;31;60;3;8,9;12,7;9,2;11,4;9,2;11,4;g/dl;g/dl;10");
      insert_ltn("Hemoglobina;61;180;3;9,6;12,4;9,9;12,4;9,9;12,4;g/dl;g/dl;10");
      insert_ltn("Hemoglobina;180;730;3;10,1;12,5;10,2;12,7;10,2;12,7;g/dl;g/dl;10");
      insert_ltn("Hemoglobina;731;2190;3;10,2;12,7;10,2;12,7;10,2;12,7;g/dl;g/dl;10");
      insert_ltn("Hemoglobina;2191;4380;3;10,7;13,4;10,6;13,2;10,6;13,2;g/dl;g/dl;10");
      insert_ltn("Hemoglobina;4381;6570;3;11;14,5;10,8;13,3;10,8;13,3;g/dl;g/dl;10");
      insert_ltn("Hemoglobina;6571;43800;3;11,9;15,4;10,6;13,5;10,6;13,5;g/dl;g/dl;10");
    insert_lt("Morfologia krwi;Hematokryt;EN_Hematokryt;Ht;HCT;1;1;2;5;250;3;350");	insert_ltn("Hematokryt;0;43800;3;33;43;39;49;39;49;%;%;1");
    insert_lt("Morfologia krwi;Erytrocyty;EN_Erytrocyty;RBC;RBC;1;1;3;5;250;3;350");	insert_ltn("Erytrocyty;0;43800;3;3,5;5;4,3;5,9;4,3;5,9;mln/μI;mln/μI;10");
    insert_lt("Morfologia krwi;MCV;EN_MCV;MCV;MCV;1;1;4;5;250;3;350");	insert_ltn("MCV;0;43800;3;81;100;81;100;81;100;fi;fi;1");
    insert_lt("Morfologia krwi;MCH;EN_MCH;MCH;MCH;1;1;5;5;250;3;350");	insert_ltn("MCH;0;43800;3;27;34;27;34;27;34;pg;pg;1");
    insert_lt("Morfologia krwi;MCHC;EN_MCHC;MCHC;MCHC;1;1;6;5;250;3;350");	insert_ltn("MCHC;0;43800;3;32;36;32;36;32;36;g/dl;g/dl;1");
    insert_lt("Morfologia krwi;Trombocyty;EN_Trombocyty;PLT;PLT;1;1;7;5;250;3;350");	insert_ltn("Trombocyty;0;43800;3;150;400;150;400;150;400;1000/μI;1000/μI;1");
    insert_lt("Morfologia krwi;Retikulocyty;EN_Retikulocyty;RC;RC;1;1;8;5;250;3;350");	insert_ltn("Retikulocyty;0;43800;3;0,5;2;0,5;2;0,5;2;%;%;10");
    insert_lt("Morfologia krwi;Leukocyty ( łącznie);EN_Leukocyty ( łącznie);WBC;WBC;1;1;9;5;250;3;350");	insert_ltn("Leukocyty ( łącznie);0;43800;3;4000;11000;4000;11000;4000;11000;/μI;/μI;1");
  insert_ltg("Morfologia krwi - rozmaz (Leukogram);EN_Morfologia krwi - rozmaz (Leukogram);1;2");	insert_lt("Morfologia krwi - rozmaz (Leukogram);Neutrofile;EN_Neutrofile;NEUT;NEUT;1;1;10;5;250;3;350");	insert_ltn("Neutrofile;0;43800;3;45;78;45;78;45;78;%;%;1");
    insert_lt("Morfologia krwi - rozmaz (Leukogram);- pałki;EN_- pałki;NEUT-pałki;NEUT-banded;1;1;11;5;250;3;350");	insert_ltn("- pałki;0;43800;3;0;4;0;4;0;4;%;%;1");
    insert_lt("Morfologia krwi - rozmaz (Leukogram);- segmenty;EN_- segmenty;NEUT-segmenty;NEUT-segmented;1;1;12;5;250;3;350");	insert_ltn("- segmenty;0;43800;3;45;74;45;74;45;74;%;%;1");
    insert_lt("Morfologia krwi - rozmaz (Leukogram);Eozynofile;EN_Eozynofile;EOS;EOS;1;1;13;5;250;3;350");	insert_ltn("Eozynofile;0;43800;3;0;7;0;7;0;7;%;%;1");
    insert_lt("Morfologia krwi - rozmaz (Leukogram);Bazofile;EN_Bazofile;BASO;BASO;1;1;14;5;250;3;350");	insert_ltn("Bazofile;0;43800;3;0;2;0;2;0;2;%;%;1");
    insert_lt("Morfologia krwi - rozmaz (Leukogram);Limfocyty;EN_Limfocyty;LYM;LYM;1;1;15;5;250;3;350");	insert_ltn("Limfocyty;0;43800;3;16;45;16;45;16;45;%;%;1");
    insert_lt("Morfologia krwi - rozmaz (Leukogram);Monocyty;EN_Monocyty;MONO;MONO;1;1;16;5;250;3;350");	insert_ltn("Monocyty;0;43800;3;4;10;4;10;4;10;%;%;1");
  insert_ltg("Gazometria krwi tętniczej;EN_Gazometria krwi tętniczej;1;3");	insert_lt("Gazometria krwi tętniczej;pH;EN_pH;S-27;E-27;1;1;17;5;250;3;350");	insert_ltn("pH;0;43800;3;7,35;7,45;7,35;7,45;7,35;7,45;;0;100");
    insert_lt("Gazometria krwi tętniczej;pC02 (krwi tętniczej);EN_pC02 (krwi tętniczej);S-28;E-28;1;1;18;5;250;3;350");	insert_ltn("pC02 (krwi tętniczej);0;43800;3;32;45;32;45;32;45;mmHg;mmHg;1");
    insert_lt("Gazometria krwi tętniczej;pO (krwi tętniczej);EN_pO (krwi tętniczej);S-29;E-29;1;1;19;5;250;3;350");	insert_ltn("pO (krwi tętniczej);0;43800;3;65;100;65;100;65;100;mmHg;mmHg;1");
    insert_lt("Gazometria krwi tętniczej;Niedobór zasad;EN_Niedobór zasad;S-30;E-30;1;1;20;5;250;3;350");	insert_ltn("Niedobór zasad;0;43800;3;-3;3;-3;3;-3;3;mmol/l;mmol/l;1");
    insert_lt("Gazometria krwi tętniczej;Węglany;EN_Węglany;S-31;E-31;1;1;21;5;250;3;350");	insert_ltn("Węglany;0;43800;3;22;26;22;26;22;26;mmol/l;mmol/l;1");
    insert_lt("Gazometria krwi tętniczej;Mleczany;EN_Mleczany;S-32;E-32;1;1;22;5;250;3;350");	insert_ltn("Mleczany;0;43800;3;4,5;20;4,5;20;4,5;20;mg/dl;mg/dl;1");
  insert_ltg("Elektrolity w osoczu;EN_Elektrolity w osoczu;2;4");	insert_lt("Elektrolity w osoczu;Sód;EN_Sód;S-33;E-33;1;1;23;5;250;3;350");	insert_ltn("Sód;0;43800;3;136;148;136;148;136;148;mmol/l;mmol/l;1");
    insert_lt("Elektrolity w osoczu;Potas;EN_Potas;S-34;E-34;1;1;24;5;250;3;350");	insert_ltn("Potas;0;43800;3;3,6;5,2;3,6;5,2;3,6;5,2;mmol/l;mmol/l;10");
    insert_lt("Elektrolity w osoczu;Wapń (całkowity);EN_Wapń (całkowity);S-35;E-35;1;2;25;5;250;3;350");	insert_ltn("Wapń (całkowity);0;43800;3;2,1;2,6;2,1;2,6;2,1;2,6;mmol/l;mmol/l;10");
    insert_lt("Elektrolity w osoczu;Wapń (zjonizowany);EN_Wapń (zjonizowany);S-36;E-36;1;2;26;5;250;3;350");	insert_ltn("Wapń (zjonizowany);0;43800;3;1,1;1,3;1,1;1,3;1,1;1,3;mmol/l;mmol/l;10");
    insert_lt("Elektrolity w osoczu;Magnez;EN_Magnez;S-37;E-37;1;2;27;5;250;3;350");	insert_ltn("Magnez;0;43800;3;0,7;1,05;0,7;1,05;0,7;1,05;mmol/l;mmol/l;100");
    insert_lt("Elektrolity w osoczu;Chlorki;EN_Chlorki;S-38;E-38;1;2;28;5;250;3;350");	insert_ltn("Chlorki;0;43800;3;97;108;97;108;97;108;mmol/l;mmol/l;1");
    insert_lt("Elektrolity w osoczu;Fosforany;EN_Fosforany;S-39;E-39;1;2;29;5;250;3;350");	insert_ltn("Fosforany;0;43800;3;0,84;1,45;0,84;1,45;0,84;1,45;mmol/l;mmol/l;100");
  insert_ltg("Wskaźniki zapalne;EN_Wskaźniki zapalne;1;5");	insert_lt("Wskaźniki zapalne;OB sposobem Westergrena;EN_OB sposobem Westergrena;S-40;E-40;1;1;30;5;250;3;350");	insert_ltn("OB sposobem Westergrena;0;18250;2;;20;;15;;15;mm po 1 h;mm after 1 h;1");
      insert_ltn("OB sposobem Westergrena;18251;43800;2;;30;;20;;20;mm po 1 h;mm after 1 h;1");
    insert_lt("Wskaźniki zapalne;CRP;EN_CRP;S-42;E-42;1;1;31;5;250;3;350");	insert_ltn("CRP;0;43800;2;;5;;5;;5;mg/l;mg/l;1");
  insert_ltg("Układ krzepnięcia;EN_Układ krzepnięcia;1;6");	insert_lt("Układ krzepnięcia;Czas krwawienia: ukłucie opuszki palca. wycierać krew gazikiem co 30 s. bez dotykania rany;EN_Czas krwawienia: ukłucie opuszki palca. wycierać krew gazikiem co 30 s. bez dotykania rany;S-43;E-43;1;1;32;5;250;3;350");	insert_ltn("Czas krwawienia: ukłucie opuszki palca. wycierać krew gazikiem co 30 s. bez dotykania rany;0;43800;2;;6;;6;;6;min;min;1");
    insert_lt("Układ krzepnięcia;APTT (czas kaolinowo-kefalinowy);EN_APTT (czas kaolinowo-kefalinowy);S-44;E-44;1;1;33;5;250;3;350");	insert_ltn("APTT (czas kaolinowo-kefalinowy);0;43800;3;28;40;28;40;28;40;s;s;1");
    insert_lt("Układ krzepnięcia;Wskaźnik Quicka (100% = INR 1.0);EN_Wskaźnik Quicka (100% = INR 1.0);S-45;E-45;1;1;34;5;250;3;350");	insert_ltn("Wskaźnik Quicka (100% = INR 1.0);0;43800;3;70;120;70;120;70;120;%;%;1");
    insert_lt("Układ krzepnięcia;Czas trombinowy;EN_Czas trombinowy;S-46;E-46;1;1;35;5;250;3;350");	insert_ltn("Czas trombinowy;0;43800;3;17;24;17;24;17;24;s;s;1");
    insert_lt("Układ krzepnięcia;Fibrynogen;EN_Fibrynogen;S-47;E-47;1;1;36;5;250;3;350");	insert_ltn("Fibrynogen;0;43800;3;1,8;3,5;1,8;3,5;1,8;3,5;g/l;g/l;10");
    insert_lt("Układ krzepnięcia;Antytrombina Ili;EN_Antytrombina Ili;S-48;E-48;1;1;37;5;250;3;350");	insert_ltn("Antytrombina Ili;0;43800;3;70;120;70;120;70;120;%;%;1");
    insert_lt("Układ krzepnięcia;D-dimery;EN_D-dimery;S-49;E-49;1;1;38;5;250;3;350");	insert_ltn("D-dimery;0;43800;2;;0,5;;0,5;;0,5;μg/ml;μg/ml;10");
  insert_ltg("Gospodarka żelazem;EN_Gospodarka żelazem;1;7");	insert_lt("Gospodarka żelazem;Żelazo;EN_Żelazo;S-50;E-50;1;1;39;5;250;3;350");	insert_ltn("Żelazo;0;43800;3;45;160;45;160;45;160;μg/dl;μg/dl;1");
    insert_lt("Gospodarka żelazem;Ferrytyna;EN_Ferrytyna;S-51;E-51;1;1;40;5;250;3;350");	insert_ltn("Ferrytyna;0;43800;3;15;250;20;500;20;500;μg/dl;μg/dl;1");
    insert_lt("Gospodarka żelazem;Transferyna;EN_Transferyna;S-52;E-52;1;1;41;5;250;3;350");	insert_ltn("Transferyna;0;43800;3;2;3,6;2;3,6;2;3,6;g/l;g/l;10");
  insert_ltg("Ocena wydolności nerek;EN_Ocena wydolności nerek;1;8");	insert_lt("Ocena wydolności nerek;Kreatynina;EN_Kreatynina;S-53;E-53;1;1;42;5;250;3;350");	insert_ltn("Kreatynina;0;43800;2;;0,9;;1,1;;1,1;mg/dl;mg/dl;10");
    insert_lt("Ocena wydolności nerek;Mocznik;EN_Mocznik;S-54;E-54;1;1;43;5;250;3;350");	insert_ltn("Mocznik;0;43800;3;12;50;12;50;12;50;mg/dl;mg/dl;1");
    insert_lt("Ocena wydolności nerek;Klirens kreatyniny w ciągu 24 godz.;EN_Klirens kreatyniny w ciągu 24 godz.;S-55;E-55;1;1;44;5;250;3;350");	insert_ltn("Klirens kreatyniny w ciągu 24 godz.;0;43800;2;;95;;110;;110;ml/min;ml/min;1");
  insert_ltg("Ocena wydolności wątroby;EN_Ocena wydolności wątroby;1;9");	insert_lt("Ocena wydolności wątroby;GOT (AspAT);EN_GOT (AspAT);S-56;E-56;1;1;45;5;250;3;350");	insert_ltn("GOT (AspAT);0;43800;2;;15;;19;;19;j.m./l;IU/l;1");
    insert_lt("Ocena wydolności wątroby;GPT (AIAT);EN_GPT (AIAT);S-57;E-57;1;1;46;5;250;3;350");	insert_ltn("GPT (AIAT);0;43800;2;;19;;23;;23;j.m./l;IU/l;1");
    insert_lt("Ocena wydolności wątroby;y-GT;EN_y-GT;S-58;E-58;1;1;47;5;250;3;350");	insert_ltn("y-GT;0;43800;2;;18;;28;;28;j.m./l;IU/l;1");
    insert_lt("Ocena wydolności wątroby;CHE;EN_CHE;S-59;E-59;1;1;48;5;250;3;350");	insert_ltn("CHE;0;43800;3;2,5;7,4;3,5;8,5;3,5;8,5;j.m./l;IU/l;10");
    insert_lt("Ocena wydolności wątroby;GLDH;EN_GLDH;S-60;E-60;1;1;49;5;250;3;350");	insert_ltn("GLDH;0;43800;2;;3;;4;;4;j.m./l;IU/l;1");
    insert_lt("Ocena wydolności wątroby;HBDH (dehydrogenaza beta-hydroksymaślanowa);EN_HBDH (dehydrogenaza beta-hydroksymaślanowa);S-61;E-61;1;1;50;5;250;3;350");	insert_ltn("HBDH (dehydrogenaza beta-hydroksymaślanowa);0;43800;3;70;135;70;135;70;135;j.m./l;IU/l;1");
    insert_lt("Ocena wydolności wątroby;Fosfataza alkaliczna;EN_Fosfataza alkaliczna;S-62;E-62;1;1;51;5;250;3;350");	insert_ltn("Fosfataza alkaliczna;0;43800;3;40;190;40;190;40;190;j.m./l;IU/l;1");
    insert_lt("Ocena wydolności wątroby;Bilirubina całkowita;EN_Bilirubina całkowita;S-63;E-63;1;1;52;5;250;3;350");	insert_ltn("Bilirubina całkowita;0;43800;2;;1,1;;1,1;;1,1;mg/dl;mg/dl;10");
    insert_lt("Ocena wydolności wątroby;Bilirubina bezpośrednia;EN_Bilirubina bezpośrednia;S-64;E-64;1;1;53;5;250;3;350");	insert_ltn("Bilirubina bezpośrednia;0;43800;2;;0,6;;0,6;;0,6;mg/dl;mg/dl;1");
    insert_lt("Ocena wydolności wątroby;Amoniak;EN_Amoniak;S-65;E-65;1;1;54;5;250;3;350");	insert_ltn("Amoniak;0;43800;2;;70;;70;;70;μg/dl;μg/dl;1");
    insert_lt("Ocena wydolności wątroby;LDH (dehydrogenaza mleczanowa);EN_LDH (dehydrogenaza mleczanowa);S-66;E-66;1;1;55;5;250;3;350");	insert_ltn("LDH (dehydrogenaza mleczanowa);0;43800;3;120;140;120;140;120;140;j.m./l;IU/l;1");
    insert_lt("Ocena wydolności wątroby;LAP (aminopeptydaza leucynowa);EN_LAP (aminopeptydaza leucynowa);S-67;E-67;1;1;56;5;250;3;350");	insert_ltn("LAP (aminopeptydaza leucynowa);0;43800;3;16;35;16;35;16;35;j.m./l;IU/l;1");
  insert_ltg("Enzymy trzustkowe;EN_Enzymy trzustkowe;1;10");	insert_lt("Enzymy trzustkowe;alfa-amylaza;EN_alfa-amylaza;S-68;E-68;1;1;57;5;250;3;350");	insert_ltn("alfa-amylaza;0;43800;3;10;53;10;53;10;53;j.m./l;IU/l;1");
    insert_lt("Enzymy trzustkowe;Lipaza;EN_Lipaza;S-69;E-69;1;1;58;5;250;3;350");	insert_ltn("Lipaza;0;43800;2;;190;;190;;190;j.m./l;IU/l;1");
    insert_lt("Enzymy trzustkowe;Elastaza 1;EN_Elastaza 1;S-70;E-70;1;1;59;5;250;3;350");	insert_ltn("Elastaza 1;0;43800;2;;2;;2;;2;ng/ml;ng/ml;1");
  insert_ltg("Badanie ogólne moczu;EN_Badanie ogólne moczu;1;11");	insert_lt("Badanie ogólne moczu;pH moczu;EN_pH moczu;S-71;E-71;1;1;60;5;250;3;350");	insert_ltn("pH moczu;0;43800;3;4,8;7,5;4,8;7,5;4,8;7,5;j.m./l;IU/l;10");
    insert_lt("Badanie ogólne moczu;mocz_kolor;EN_mocz_kolor;mocz_kolor;E-72;2;1;61;5;250;3;350");	insert_ltn("mocz_kolor;0;43800;6;;;;;;;;;1");
      
    }
}
