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
        Schema::create('scene_lab_results', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('scene_lab_template_id');
          $table->unsignedBigInteger('laboratory_test_id');
          $table->Integer('slr_result')->nullable()->default(null);
          $table->string('slr_resulttxt')->nullable()->default(null);
          $table->string('slr_addedtext')->nullable()->default(null);
          $table->smallInteger('slr_type')->default(1);
          $table->timestamps();
      });
      Schema::table('scene_lab_results', function (Blueprint $table) {
        $table->foreign('scene_lab_template_id')
            ->references('id')
            ->on('scene_lab_templates');
      });
      Schema::table('scene_lab_results', function (Blueprint $table) {
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
      Schema::table('scene_lab_results', function (Blueprint $table) {
        $table->dropForeign(['scene_lab_template_id']);
        });
      Schema::table('scene_lab_results', function (Blueprint $table) {
        $table->dropForeign(['laboratory_test_id']);
        });
      Schema::dropIfExists('scene_lab_results');
    }
};
