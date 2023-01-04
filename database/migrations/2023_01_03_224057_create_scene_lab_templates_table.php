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
        Schema::create('scene_lab_templates', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('scene_actor_id');
          $table->unsignedBigInteger('lab_template_id')->nullable();
          $table->dateTime('slt_date');
          $table->Integer('slt_lrt_minutes_before')->default(0);
          $table->timestamps();
      });
      Schema::table('scene_lab_templates', function (Blueprint $table) {
        $table->foreign('scene_actor_id')
            ->references('id')
            ->on('scene_actors');
      });
      Schema::table('scene_lab_templates', function (Blueprint $table) {
        $table->foreign('lab_template_id')
            ->references('id')
            ->on('lab_templates');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('scene_lab_templates', function (Blueprint $table) {
        $table->dropForeign(['scene_actor_id']);
        });
      Schema::table('scene_lab_templates', function (Blueprint $table) {
        $table->dropForeign(['lab_template_id']);
        });
      Schema::dropIfExists('scene_lab_templates');
    }
};
