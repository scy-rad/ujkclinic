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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scenario_id');
            $table->integer('character_incoming_recalculate')->default(0);
            $table->smallInteger('character_age_from');
            $table->smallInteger('character_age_to');
            $table->smallInteger('character_age_interval'); // 1 - lata,  2 - miesiąca, 3 - tygodnie, 4 - dni,  5 - godziny,  6 - minuty
            $table->smallInteger('character_sex');  // 1 - nieistotna,  2 - mężczyzna,  3 - kobieta
            $table->smallInteger('character_nn')->default(0);  // 1 - NN, 0 - knowlny
            $table->unsignedBigInteger('character_role_plan_id')->default('1'); //1 - rola pierwszoplanowa, 2 - rola drugoplanowa
            $table->string('character_role_name');
            $table->unsignedBigInteger('character_type_id');
            $table->text('history_for_actor');
            $table->text('character_simulation');
            $table->smallInteger('character_status')->default(1);	
            $table->timestamps();
        });

        Schema::table('characters', function (Blueprint $table) {
          $table->foreign('scenario_id')
              ->references('id')
              ->on('scenarios');
        });
        Schema::table('characters', function (Blueprint $table) {
          $table->foreign('character_role_plan_id')
              ->references('id')
              ->on('character_role_plans');
        });

        Schema::table('characters', function (Blueprint $table) {
          $table->foreign('character_type_id')
              ->references('id')
              ->on('character_types');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('characters', function (Blueprint $table) {
        $table->dropForeign(['scenario_id']);
        });
      Schema::table('characters', function (Blueprint $table) {
        $table->dropForeign(['character_role_plan_id']);
        });
      Schema::table('characters', function (Blueprint $table) {
        $table->dropForeign(['character_type_id']);
        });
        Schema::dropIfExists('characters');
    }
};
