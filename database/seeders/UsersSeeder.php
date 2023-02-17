<?php
//php artisan db:seed --class=UsersSeeder

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserTitle;
use App\Models\UserPhoneType;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $administrator_role = UserRole::where('role_code','administrators')->first()->id;
      $technician_role = UserRole::where('role_code','technicians')->first()->id;
      $coordinator_role = UserRole::where('role_code','coordinators')->first()->id;
      $simoperator_role = UserRole::where('role_code','simoperators')->first()->id;
      $itemoperator_role = UserRole::where('role_code','itemoperators')->first()->id;
      $storeoperator_role = UserRole::where('role_code','storeoperator')->first()->id;
      $hroperator_role = UserRole::where('role_code','hroperators')->first()->id;      
      $leader_role = UserRole::where('role_code','leaders')->first()->id;
      $worker_role = UserRole::where('role_code','workers')->first()->id;      
      $scene_doctor_role = UserRole::where('role_code','scene_doctor')->first()->id;
      $scene_nurse_role = UserRole::where('role_code','scene_nurse')->first()->id;
      $scene_midwife_role = UserRole::where('role_code','scene_midwife')->first()->id;
      $scene_paramedic_role = UserRole::where('role_code','scene_paramedic')->first()->id;
      

      $no_title = UserTitle::where('user_title_short','')->first()->id;
      $tech_title = UserTitle::where('user_title_short','tech.')->first()->id;
      $lic_title = UserTitle::where('user_title_short','lic.')->first()->id;
      $inz_title = UserTitle::where('user_title_short','inż.')->first()->id;
      $mgr_title = UserTitle::where('user_title_short','mgr')->first()->id;
      $lekmed_title = UserTitle::where('user_title_short','lek. med.')->first()->id;
      $lekarz_title = UserTitle::where('user_title_short','lekarz')->first()->id;
      $mgrinz_title = UserTitle::where('user_title_short','mgr inż.')->first()->id;
      $dr_title = UserTitle::where('user_title_short','dr')->first()->id;
      $dr_title = UserTitle::where('user_title_short','dr n. med.')->first()->id;
      $dr_title = UserTitle::where('user_title_short','dr hab.')->first()->id;
      $dr_title = UserTitle::where('user_title_short','dr hab. prof. UJK')->first()->id;
      $prof_title = UserTitle::where('user_title_short','prof. dr hab.')->first()->id;

      $mgrpiel_title = UserTitle::where('user_title_short','mgr piel.')->first()->id;
      $mgrpol_title = UserTitle::where('user_title_short','mgr poł.')->first()->id;
      $ratmed_title = UserTitle::where('user_title_short','rat-med.')->first()->id;



      $ph_sta_slu = UserPhoneType::where('user_phone_type_name','stacjonarny służbowy')->first()->id;
      $ph_kom_slu = UserPhoneType::where('user_phone_type_name','komórkowy służbowy')->first()->id;
      $ph_sta_prv = UserPhoneType::where('user_phone_type_name','stacjonarny prywatny')->first()->id;
      $ph_kom_prv = UserPhoneType::where('user_phone_type_name','komórkowy prywatny')->first()->id;

      $phone_for_coor=[1,0,0,0,0];
      $phone_for_tech=[1,1,0,0,0];
      $phone_for_all=[1,1,1,1,1];



      $user = new User();
      $user->name = 'sebek';
      $user->user_title_id = $mgrinz_title;
      $user->lastname = 'Dudek';
      $user->firstname = 'Sebastian';
      $user->about = 'Technik symulacji medycznej na wydziale lekarskim.<br>Zajmuje się prowadzeniem strony internetowej. W wolnych chwilach (których nie ma) majsterkuje :)<br>Lubi jazdę na rowerze i dynamiczne symulacje.';
      $user->email = 'sebastian@mailtrap.io';
      $user->user_status = 1;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($technician_role);
      $user->add_phone('41 349-69-24', $ph_sta_slu, $phone_for_all);
      $user->add_phone('737-333-755', $ph_kom_prv, $phone_for_tech);


      $user = new User();
      $user->name = 'admindudek';
      $user->user_title_id = $mgrinz_title;
      $user->lastname = 'Admin';
      $user->firstname = 'Sebastian';
      $user->email = 'admin@mailtrap.io';
      $user->user_status = 1;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($administrator_role);
      $user->add_role($storeoperator_role);
      $user->add_role($simoperator_role);
      $user->add_role($itemoperator_role);
      $user->add_role($technician_role);
      $user->add_phone('41 349-69-24', $ph_sta_slu, $phone_for_all);
      $user->add_phone('73-73-337-55', $ph_kom_prv, $phone_for_coor);

      $user = new User();
      $user->name = '_nikt';
      $user->user_title_id = $no_title;
      $user->lastname = '_Nikt';
      $user->firstname = '-';
      $user->email = 'nomail@nomail';
      $user->user_status = 1;
      $user->simmed_notify = 0;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($leader_role);
      $user->add_role($technician_role);

      $user = new User();
      $user->name = 'instruktor';
      $user->user_title_id = $no_title;
      $user->lastname = 'Lekarka/Pielęgniarka/Ratowniczka';
      $user->firstname = 'Pan lub Pani';
      $user->about = 'instruktor pracująy w CSM.';
      $user->email = 'instruktor@mailtrap.io';
      $user->user_status = 1;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($leader_role);

      $user = new User();
      $user->name = 'technik';
      $user->user_title_id = $mgrinz_title;
      $user->lastname = 'Technik';
      $user->firstname = 'Pan';
      $user->about = 'Technik Symulacji Medycznej pracująy w CSM.';
      $user->email = 'technik@mailtrap.io';
      $user->user_status = 1;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($technician_role);

      $user = new User();
      $user->name = 'koordynator';
      $user->user_title_id = $lekmed_title;
      $user->lastname = 'Koordynator';
      $user->firstname = 'Pan';
      $user->about = 'koordynator CSM.';
      $user->email = 'koordynator@mailtrap.io';
      $user->user_status = 1;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($coordinator_role);

      $user = new User();
      $user->name = 'SimOp';
      $user->user_title_id = $no_title;
      $user->lastname = 'Operator';
      $user->firstname = 'Symulacji';
      $user->about = 'Operator symulacji.';
      $user->email = 'simoperator@mailtrap.io';
      $user->user_status = 1;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($simoperator_role);

      $user = new User();
      $user->name = 'HrOp';
      $user->user_title_id = $no_title;
      $user->lastname = 'Operator';
      $user->firstname = 'Kadr';
      $user->about = 'Operator kadr.';
      $user->email = 'hroperator@mailtrap.io';
      $user->user_status = 1;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($hroperator_role);






      $user = new User();
      $user->name = 'Lekarz z MedUJK';
      $user->user_title_id = $lekmed_title;
      $user->lastname = 'Lakarz';
      $user->firstname = 'C2.07';
      $user->about = 'Lekarka/Lekarz MedUJK';
      $user->email = 'scene_doctor@mailtrap.io';
      $user->user_status = 1;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($scene_doctor_role);

      $user = new User();
      $user->name = 'Pielęgniarka z MedUJK';
      $user->user_title_id = $mgrpiel_title;
      $user->lastname = 'Pielegniarka';
      $user->firstname = 'C2.07';
      $user->about = 'Pielęgniarka/Pielęgniarz MedUJK';
      $user->email = 'scene_nurse@mailtrap.io';
      $user->user_status = 1;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($scene_nurse_role);

      $user = new User();
      $user->name = 'Położna z MedUJK';
      $user->user_title_id = $mgrpol_title;
      $user->lastname = 'Położna';
      $user->firstname = 'C2.07';
      $user->about = 'Położna/Położny MedUJK';
      $user->email = 'scene_midwife@mailtrap.io';
      $user->user_status = 1;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($scene_midwife_role);

      $user = new User();
      $user->name = 'Ratownik Medyczny z MedUJK';
      $user->user_title_id = $ratmed_title;
      $user->lastname = 'Ratownik';
      $user->firstname = 'C2.07';
      $user->about = 'Ratownik/Ratowniczka Medyczna MedUJK';
      $user->email = 'scene_paramedic@mailtrap.io';
      $user->user_status = 1;
      $user->password = bcrypt('medujk');
      $user->save();
      $user->add_role($scene_paramedic_role);

    }

  }