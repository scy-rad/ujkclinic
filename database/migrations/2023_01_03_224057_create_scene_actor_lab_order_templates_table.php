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
        Schema::create('scene_actor_lab_order_templates', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('scene_actor_id');
          $table->unsignedBigInteger('lab_order_template_id')->nullable();
          $table->Integer('salot_lrt_minutes_before')->default(0);
          $table->string('salo_descript')->nullable();
          $table->timestamps();
      });
      Schema::table('scene_actor_lab_order_templates', function (Blueprint $table) {
        $table->foreign('scene_actor_id')
            ->references('id')
            ->on('scene_actors');
      });
      Schema::table('scene_actor_lab_order_templates', function (Blueprint $table) {
        $table->foreign('lab_order_template_id')
            ->references('id')
            ->on('lab_order_templates');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('scene_actor_lab_order_templates', function (Blueprint $table) {
        $table->dropForeign(['scene_actor_id']);
        });
      Schema::table('scene_actor_lab_order_templates', function (Blueprint $table) {
        $table->dropForeign(['lab_order_template_id']);
        });
      Schema::dropIfExists('scene_actor_lab_order_templates');
    }
};
