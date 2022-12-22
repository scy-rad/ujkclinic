<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scenario_id');
            $table->smallInteger('actor_age_from');
            $table->smallInteger('actor_age_to');
            $table->smallInteger('actor_age_interval'); // 1 - lata,  2 - miesiąca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
            $table->smallInteger('actor_sex');  // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
            $table->unsignedBigInteger('actor_role_plan_id')->default('1'); //1 - rola pierwszoplanowa, 2 - rola drugoplanowa
            $table->string('actor_role_name');
            $table->unsignedBigInteger('actor_type_id');
            $table->text('history_for_actor');
            $table->text('actor_simulation');
            $table->smallInteger('actor_status')->default(1);	
            $table->timestamps();
        });

        Schema::table('actors', function (Blueprint $table) {
          $table->foreign('scenario_id')
              ->references('id')
              ->on('scenarios');
        });
        Schema::table('actors', function (Blueprint $table) {
          $table->foreign('actor_role_plan_id')
              ->references('id')
              ->on('actor_role_plans');
        });

        Schema::table('actors', function (Blueprint $table) {
          $table->foreign('actor_type_id')
              ->references('id')
              ->on('actor_types');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('actors', function (Blueprint $table) {
        $table->dropForeign(['scenario_id']);
        });
      Schema::table('actors', function (Blueprint $table) {
        $table->dropForeign(['actor_role_plan_id']);
        });
      Schema::table('actors', function (Blueprint $table) {
        $table->dropForeign(['actor_type_id']);
        });
        Schema::dropIfExists('actors');
    }
};
