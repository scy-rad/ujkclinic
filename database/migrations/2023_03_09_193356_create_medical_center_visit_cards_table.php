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
        Schema::create('medical_center_visit_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scene_actor_id');
            $table->dateTime('mcvc_begin');
            $table->dateTime('mcvc_end')->nullable();
            $table->text('mcvc_medical_history')->nullable();
            $table->text('mcvc_medical_examination')->nullable();
            $table->text('mcvc_medical_orders')->nullable();
            $table->text('mcvc_comments')->nullable();
            $table->timestamps();
        });
        Schema::table('medical_center_visit_cards', function (Blueprint $table) {
          $table->foreign('scene_actor_id')
              ->references('id')
              ->on('scene_actors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_center_visit_cards', function (Blueprint $table) {
          $table->dropForeign(['scene_actor_id']);
          });
        Schema::dropIfExists('medical_center_visit_cards');
    }
};
