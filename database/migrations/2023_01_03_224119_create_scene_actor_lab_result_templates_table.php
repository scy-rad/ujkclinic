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
        Schema::create('scene_actor_lab_result_templates', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('salot_id');
          $table->unsignedBigInteger('laboratory_test_id');
          $table->Integer('salr_result')->nullable()->default(null);
          $table->string('salr_resulttxt')->nullable()->default(null);
          $table->string('salr_addedtext')->nullable()->default(null);
          $table->smallInteger('salr_type')->default(1);
          $table->timestamps();
      });
      Schema::table('scene_actor_lab_result_templates', function (Blueprint $table) {
        $table->foreign('salot_id')
            ->references('id')
            ->on('scene_actor_lab_order_templates');
      });
      Schema::table('scene_actor_lab_result_templates', function (Blueprint $table) {
        $table->foreign('laboratory_test_id')
            ->references('id')
            ->on('laboratory_tests');
      });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::table('scene_actor_lab_result_templates', function (Blueprint $table) {
        $table->dropForeign(['salot_id']);
        });
      Schema::table('scene_actor_lab_result_templates', function (Blueprint $table) {
        $table->dropForeign(['laboratory_test_id']);
        });
      Schema::dropIfExists('scene_actor_lab_result_templates');
    }
};
