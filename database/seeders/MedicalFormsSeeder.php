<?php
//php artisan db:seed --class=MedicalFormsSeeder

namespace Database\Seeders;

use App\Models\MedicalFormFamilly;
use App\Models\MedicalFormType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;

class MedicalFormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      Schema::disableForeignKeyConstraints();
      MedicalFormType::truncate();
      MedicalFormFamilly::truncate();
      Schema::enableForeignKeyConstraints();

      function insert_form_familly($tab)
      {
        $table = new MedicalFormFamilly();
        $table->mff_name = $tab[0];
        $table->mff_short = $tab[1];
        $table->mff_code = $tab[2];
        $table->mff_icon = $tab[3];
        $table->mff_sort = $tab[4];
        $table->save();
      } 
      function insert_form_type($tab)
      {
        $mff_id=MedicalFormFamilly::where('mff_code',$tab[0])->first()->id;
        
        $table = new MedicalFormType();
        $table->medical_form_familly_id = $mff_id;
        $table->mft_name = $tab[1];
        $table->mft_short = $tab[2];
        $table->mft_code = $tab[3];
        $table->mft_show_skeleton = $tab[4];
        $table->mft_edit_skeleton = $tab[5];
        $table->mft_sort = $tab[6];
        $table->save();
      }

      // insert_form_familly('name','short','code','icon','sort');

      insert_form_familly(['skierowania','skier.','SKIE','<i class="bi bi-stack-overflow"></i>',1]);
      insert_form_familly(['zlecenia','zlec.','ZLEC','<i class="bi bi-file-earmark-ruled"></i>',2]);
      insert_form_familly(['zaświadczenia','zaśw.','ZASW','<i class="bi bi-file-earmark-ruled"></i>',3]);
      
      // insert_form_type('familly_short','name','short','code','show_sceleton','edit_sceleton','sort');

      insert_form_type(['SKIE','do badania radiologicznego','bad. RTG','SK_RAD','s_skie_badanie_rtg.php','e_skie_badanie_rtg.php',1]);
      insert_form_type(['SKIE','do badania ultrasonograficznego','bad. USG','SK_USG','s_skie_badanie_usg.php','e_skie_badanie_usg.php',2]);
      insert_form_type(['SKIE','do poradni specjalistycznej','por. spec.','SK_SPE','s_skie_poradnia_specjalistyczna.php','e_skie_poradnia_specjalistyczna.php',3]);
      insert_form_type(['SKIE','na badania czynnościowe','bad. czyn.','SK_CZY','s_skie_badanie_czynnosciowe.php','e_skie_badanie_czynnosciowe.php',4]);
      insert_form_type(['SKIE','na fizjoterapię','fizjo.','SK_FIZ','s_skie_fizjoterapia.php','e_skie_fizjoterapia.php',5]);
      insert_form_type(['SKIE','do szpitala','szpit.','SK_SZP','s_skie_szpital.php','e_skie_szpital.php',6]);

      insert_form_type(['ZLEC','na zabiegi pielęgniarskie','zab. piel.','ZL_PIE','s_zlec_zabiegi_pielegniarskie.php','e_zlec_zabiegi_pielegniarskie.php',1]);
      insert_form_type(['ZLEC','na transport','trans.','ZL_TRA','s_zlec_transport.php','e_zlec_transport.php',2]);

      insert_form_type(['ZASW','zaświadczenie ogólne','zas.','ZA_OG','s_zasw_ogolne.php','e_zasw_ogolne.php',2]);

    }
}
