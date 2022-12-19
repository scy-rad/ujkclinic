<?php
//php artisan db:seed --class=UserRolesSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRolesSeeder extends Seeder
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
      $user_role->role_code="administrator";
      $user_role->role_color="red";
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name="Instruktor";
      $user_role->role_names="instruktorzy";
      $user_role->role_short="instr";
      $user_role->role_description="prowadzący zajęcia";
      $user_role->role_code="leader";
      $user_role->role_color="blue";
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name="Student";
      $user_role->role_names="Studenci";
      $user_role->role_short="stud";
      $user_role->role_description="Personel medyczny Centrum Symulacji";
      $user_role->role_code="student";
      $user_role->role_color="green";
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name="Laborant";
      $user_role->role_names="Laboranci";
      $user_role->role_short="lab";
      $user_role->role_description="Pracownik laboratorium Centrum Symulacji";
      $user_role->role_code="labtechnician";
      $user_role->role_color="green";
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name="Lekarz";
      $user_role->role_names="Lekarze";
      $user_role->role_short="lek";
      $user_role->role_description="Lekarze Centrum Symulacji";
      $user_role->role_code="doctor";
      $user_role->role_color="green";
      $user_role->save();

      $user_role = new UserRole();
      $user_role->role_name="Pielegniarz";
      $user_role->role_names="Pielęgniarze";
      $user_role->role_short="piel";
      $user_role->role_description="Pielęgniarze Centrum Symulacji";
      $user_role->role_code="nurse";
      $user_role->role_color="green";
      $user_role->save();
    }
}
