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
        Schema::create('scenarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scenario_author_id')->nullable();
            $table->unsignedBigInteger('center_id');
            $table->unsignedBigInteger('scenario_type_id');
            $table->unsignedBigInteger('scene_type_id');
            $table->string('scenario_name');
            $table->string('scenario_code');
            $table->string('scenario_main_problem');
            $table->text('scenario_description');
            $table->text('scenario_for_students');
            $table->text('scenario_for_leader');
            $table->text('scenario_helpers_for_students')->nullable();
            $table->text('scenario_logs_for_students')->nullable();
            $table->smallInteger('scenario_status')->default(1);	
            $table->timestamps();
        });

        Schema::table('scenarios', function (Blueprint $table) {
          $table->foreign('center_id')
              ->references('id')
              ->on('centers');
        });

        Schema::table('scenarios', function (Blueprint $table) {
          $table->foreign('scenario_author_id')
              ->references('id')
              ->on('users');
        });

        Schema::table('scenarios', function (Blueprint $table) {
          $table->foreign('scenario_type_id')
              ->references('id')
              ->on('scenario_types');
        });

        Schema::table('scenarios', function (Blueprint $table) {
          $table->foreign('scene_type_id')
              ->references('id')
              ->on('scene_types');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('scenarios', function (Blueprint $table) {
        $table->dropForeign(['center_id']);
        });
      Schema::table('scenarios', function (Blueprint $table) {
        $table->dropForeign(['scenario_author_id']);
        });
      Schema::table('scenarios', function (Blueprint $table) {
        $table->dropForeign(['scenario_type_id']);
        });
      Schema::table('scenarios', function (Blueprint $table) {
        $table->dropForeign(['scene_type_id']);
        });
  
      Schema::dropIfExists('scenarios');
    }
};
