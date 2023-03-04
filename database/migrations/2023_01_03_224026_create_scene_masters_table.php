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
      /*
      scene_status:   1 - robocza
                      2 - aktywna
                      3 - zatrzymana
                      4 - zakończona
      */
        Schema::create('scene_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scenario_id')->nullable();
            $table->unsignedBigInteger('scene_type_id');
            $table->unsignedBigInteger('scene_owner_id');
            $table->string('scene_code');
            $table->string('scene_name');
            $table->datetime('scene_date');
            $table->datetime('scene_relative_date')->nullable();
            $table->Integer('scene_relative_id')->default(1);
            $table->Integer('scene_step_minutes');
            $table->Integer('scene_lab_take_seconds_from');
            $table->Integer('scene_lab_take_seconds_to');
            $table->Integer('scene_lab_delivery_seconds_from');
            $table->Integer('scene_lab_delivery_seconds_to');
            $table->smallInteger('scene_lab_automatic_time')->default(1);            
            $table->text('scene_scenario_description');
            $table->text('scene_scenario_for_students');
            $table->smallInteger('scene_status')->default(1);            
            $table->timestamps();
        });
        Schema::table('scene_masters', function (Blueprint $table) {
          $table->foreign('scenario_id')
              ->references('id')
              ->on('scenarios');
        });
        Schema::table('scene_masters', function (Blueprint $table) {
          $table->foreign('scene_type_id')
              ->references('id')
              ->on('scene_types');
        });
        Schema::table('scene_masters', function (Blueprint $table) {
          $table->foreign('scene_owner_id')
              ->references('id')
              ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('scene_masters', function (Blueprint $table) {
        $table->dropForeign(['scenario_id']);
        });
      Schema::table('scene_masters', function (Blueprint $table) {
        $table->dropForeign(['scene_type_id']);
        });
      Schema::table('scene_masters', function (Blueprint $table) {
        $table->dropForeign(['scene_owner_id']);
        });
      Schema::dropIfExists('scene_masters');
    }
};
