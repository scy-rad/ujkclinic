<?php
//php artisan db:seed --class=ConsultationTypes

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConsultationType;

class ConsultationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scetype = new ConsultationType();
        $scetype->id = 1; 
        $scetype->cont_name = "Konsultację";
        $scetype->cont_head = "konsultację";
        $scetype->save();

        $scetype = new ConsultationType();
        $scetype->id = 2; 
        $scetype->cont_name = "Badanie diagostyczne";
        $scetype->cont_head = "badanie diagostyczne";
        $scetype->save();


        
    }
    
}
