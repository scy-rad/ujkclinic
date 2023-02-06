<?php
//php artisan db:seed --class=ScenarioConsultationTemplateTypes

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ScenarioConsultationTemplateType;

class ScenarioConsultationTemplateTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scetype = new ScenarioConsultationTemplateType();
        $scetype->id = 1; 
        $scetype->sctt_name = "Konsultację";
        $scetype->sctt_head = "konsultację";
        $scetype->save();

        $scetype = new ScenarioConsultationTemplateType();
        $scetype->id = 2; 
        $scetype->sctt_name = "Badanie diagostyczne";
        $scetype->sctt_head = "badanie diagostyczne";
        $scetype->save();


        
    }
    
}
