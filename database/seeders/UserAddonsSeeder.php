<?php
//php artisan db:seed --class=UserAddonsSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRole;
use App\Models\UserTitle;
use App\Models\UserPhoneType;

class UserAddonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
      $user_role = new UserRole();
      $user_role->role_name="administrator";
      $user_role->role_names="administratorzy";
      $user_role->role_short="admin";
      $user_role->role_description="administrator systemu";
      $user_role->role_code="administrators";
      $user_role->role_color="red";
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name = 'Koordynator';
      $user_role->role_names = 'Koordynatorzy';
      $user_role->role_short = 'Koord';
      $user_role->role_description = ' ';
      $user_role->role_code = 'coordinators';
      $user_role->role_color = 'success';
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name = 'Technik Symulacji';
      $user_role->role_names = 'Technicy Symulacji';
      $user_role->role_short = 'Tech.Sym.';
      $user_role->role_description = ' ';
      $user_role->role_code = 'technicians';
      $user_role->role_color = 'success';
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name = 'Operator Symulacji';
      $user_role->role_names = 'Operatorzy Symulacji';
      $user_role->role_short = 'Op.Sym.';
      $user_role->role_description = ' ';
      $user_role->role_code = 'simoperators';
      $user_role->role_color = 'green';
      $user_role->save();
  
      $user_role = new UserRole();
      $user_role->role_name = 'Operator Zasobów';
      $user_role->role_names = 'Operatorzy Zasobów';
      $user_role->role_short = 'Op.Zas.';
      $user_role->role_description = 'zarządzanie inwentaryzacji';
      $user_role->role_code = 'itemoperators';
      $user_role->role_color = 'success';
      $user_role->save();
  
      $user_role = new UserRole();
      $user_role->role_name = 'Operator Kadr';
      $user_role->role_names = 'Operatorzy Kadr';
      $user_role->role_short = 'Op.Kadr';
      $user_role->role_description = 'edytowanie, dodawanie i usuwanie użytkowników, zmiana uprawnień';
      $user_role->role_code = 'hroperators';
      $user_role->role_color = 'success';
      $user_role->save();
  
      $user_role = new UserRole();
      $user_role->role_name = 'Magazynier';
      $user_role->role_names = 'Magazynierzy';
      $user_role->role_short = 'Mag-er';
      $user_role->role_description = 'edytowanie i zamykanie zgłoszeń serwisowych, obsługa przeglądów, wypożyczenie zasobów, wykonywanie inwentaryzacji';
      $user_role->role_code = 'storeoperator';
      $user_role->role_color = 'success';
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name="Instruktor";
      $user_role->role_names="instruktorzy";
      $user_role->role_short="instr";
      $user_role->role_description="prowadzący zajęcia";
      $user_role->role_code="leaders";
      $user_role->role_color="blue";
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name = 'Pracownik';
      $user_role->role_names = 'Pracownicy';
      $user_role->role_short = 'Prac.';
      $user_role->role_description = ' ';
      $user_role->role_code = 'workers';
      $user_role->role_color = 'success';
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name="Lekarz";
      $user_role->role_names="Lekarze";
      $user_role->role_short="lek";
      $user_role->role_description="Lekarze Centrum Symulacji";
      $user_role->role_code="scene_doctor";
      $user_role->role_color="green";
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name="Pielegniarz";
      $user_role->role_names="Pielęgniarze";
      $user_role->role_short="piel";
      $user_role->role_description="Pielęgniarze Centrum Symulacji";
      $user_role->role_code="scene_nurse";
      $user_role->role_color="green";
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name="Położny";
      $user_role->role_names="Położni";
      $user_role->role_short="poł";
      $user_role->role_description="Położni Centrum Symulacji";
      $user_role->role_code="scene_midwife";
      $user_role->role_color="green";
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name="Ratowik Medyczny";
      $user_role->role_names="Ratowicy Medyczni";
      $user_role->role_short="rat-med";
      $user_role->role_description="Ratownicy Centrum Symulacji";
      $user_role->role_code="scene_paramedic";
      $user_role->role_color="green";
      $user_role->save();












      $sort=1;
      $titlen = new UserTitle();
      $titlen->user_title_short = '';
      $titlen->user_title_sort = $sort++;
      $titlen->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'tech.';
      $title->user_title_sort = $sort++;
      $title->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'lic.';
      $title->user_title_sort = $sort++;
      $title->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'inż.';
      $title->user_title_sort = $sort++;
      $title->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'mgr';
      $title->user_title_sort = $sort++;
      $title->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'lek. med.';
      $title->user_title_sort = $sort++;
      $title->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'lekarz';
      $title->user_title_sort = $sort++;
      $title->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'mgr inż.';
      $title->user_title_sort = $sort++;
      $title->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'dr';
      $title->user_title_sort = $sort++;
      $title->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'dr n. med.';
      $title->user_title_sort = $sort++;
      $title->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'dr hab.';
      $title->user_title_sort = $sort++;
      $title->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'dr hab. prof. UJK';
      $title->user_title_sort = $sort++;
      $title->save();
  
      $title = new UserTitle();
      $title->user_title_short = 'prof. dr hab.';
      $title->user_title_sort = $sort++;
      $title->save();

      $title = new UserTitle();
      $title->user_title_short = 'mgr piel.';
      $title->user_title_sort = $sort++;
      $title->save();

      $title = new UserTitle();
      $title->user_title_short = 'mgr poł.';
      $title->user_title_sort = $sort++;
      $title->save();

      $title = new UserTitle();
      $title->user_title_short = 'rat-med.';
      $title->user_title_sort = $sort++;
      $title->save();







      $phtype = new UserPhoneType();
      $phtype->user_phone_type_name='stacjonarny służbowy';
      $phtype->user_phone_type_short='stac. sł.';
      $phtype->user_phone_type_glyphicon='bi-telephone';
      $phtype->user_phone_type_sort = $sort++;
      $phtype->save();
  
      $phtype = new UserPhoneType();
      $phtype->user_phone_type_name='komórkowy służbowy';
      $phtype->user_phone_type_short='kom. sł.';
      $phtype->user_phone_type_glyphicon='bi-phone';
      $phtype->user_phone_type_sort = $sort++;
      $phtype->save();
  
      $phtype = new UserPhoneType();
      $phtype->user_phone_type_name='stacjonarny prywatny';
      $phtype->user_phone_type_short='stac. pryw.';
      $phtype->user_phone_type_glyphicon='bi-house-fill';
      $phtype->user_phone_type_sort = $sort++;
      $phtype->save();
  
      $phtype = new UserPhoneType();
      $phtype->user_phone_type_name='komórkowy prywatny';
      $phtype->user_phone_type_short='kom. pryw.';
      $phtype->user_phone_type_glyphicon='bi-house-fill';
      $phtype->user_phone_type_sort = $sort++;
      $phtype->save();
  
  
  
    }
}
