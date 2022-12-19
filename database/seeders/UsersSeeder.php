<?php
//php artisan db:seed --class=UsersSeeder

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = new User();
      $user->name = 'admin';
      $user->email = 'sebastian@mailtrap.io';
      $user->email_verified_at= date('Y-m-d H:i:s');
      $user->password = bcrypt('medujk');
      $user->save();

      $user = new User();
      $user->name = 'instruktor';
      $user->email = 'instruktor@mailtrap.io';
      $user->email_verified_at= date('Y-m-d H:i:s');
      $user->password = bcrypt('medujk');
      $user->save();

      $user = new User();
      $user->name = 'student';
      $user->email = 'student@mailtrap.io';
      $user->email_verified_at= date('Y-m-d H:i:s');
      $user->password = bcrypt('medujk');
      $user->save();

      $user = new User();
      $user->name = 'laborant';
      $user->email = 'laborant@mailtrap.io';
      $user->email_verified_at= date('Y-m-d H:i:s');
      $user->password = bcrypt('medujk');
      $user->save();

      $user = new User();
      $user->name = 'lekarz';
      $user->email = 'lekarz@mailtrap.io';
      $user->email_verified_at= date('Y-m-d H:i:s');
      $user->password = bcrypt('medujk');
      $user->save();

      $user = new User();
      $user->name = 'pielegniarz';
      $user->email = 'pielegniarz@mailtrap.io';
      $user->email_verified_at= date('Y-m-d H:i:s');
      $user->password = bcrypt('medujk');
      $user->save();




    }
}
