<?php
//php artisan migrate:refresh --seed
//composer dump-autoload

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
          UserAddonsSeeder::class,
          UsersSeeder::class,

          CenterSeeder::class,

          LaboratoryNormsSeeder::class,

          SceneTypesSeeder::class,
          ScenarioTypesSeeder::class,
          ConsultationTypesSeeder::class,
          CharacterTypesSeeder::class,
          CharacterRolePlansSeeder::class,
          CharacterNamesSeeder::class,
          
          ScenariosSeeder::class,

          ScenePersonelTypesSeeder::class,

      ]);

    }
}
