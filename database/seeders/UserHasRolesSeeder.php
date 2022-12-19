<?php
//php artisan db:seed --class=UserHasRolesSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserHasRole;

class UserHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      function add_user_role($sF_user,$sF_role)
      {
        if (\App\Models\User::where('name',$sF_user)->first() != null)
        $aF_user_id = \App\Models\User::where('name',$sF_user)->first()->id;
        if (\App\Models\UserRole::where('role_code',$sF_role)->first() != null)
        $aF_role_id = \App\Models\UserRole::where('role_code',$sF_role)->first()->id;
        $add_role = new UserHasRole();
        $add_role->user_id = $aF_user_id;
        $add_role->role_id = $aF_role_id;
        $add_role->save;
      }

        add_user_role('admin','administrator');
        add_user_role('instruktor','leader');
        add_user_role('student','student');
        add_user_role('laborant','labtechnician');
        add_user_role('lekarz','doctor');
        add_user_role('pielegniarz','nurse');

        
    }
}
