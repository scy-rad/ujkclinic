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
      lrtr_type:  1:  OK
                  2:  Laboratory error
                  3:  test unavailable
      */
        Schema::create('scene_actor_lab_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scene_actor_lab_order_id');
            $table->unsignedBigInteger('laboratory_test_id');
            $table->dateTime('salr_date')->nullable();
            $table->Integer('salr_result')->nullable()->default(null);
            $table->string('salr_resulttxt')->nullable()->default(null);
            $table->string('salr_addedtext')->nullable()->default(null);
            $table->Integer('salr_lo_sort');
            $table->Integer('salr_log_sort');
            $table->smallInteger('salr_type')->default(3);
            $table->timestamps();
        });
          
        Schema::table('scene_actor_lab_results', function (Blueprint $table) {
          $table->foreign('scene_actor_lab_order_id')
              ->references('id')
              ->on('scene_actor_lab_orders');
        });
        Schema::table('scene_actor_lab_results', function (Blueprint $table) {
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
      Schema::table('scene_actor_lab_results', function (Blueprint $table) {
        $table->dropForeign(['scene_actor_lab_order_id']);
        });
      Schema::table('scene_actor_lab_results', function (Blueprint $table) {
        $table->dropForeign(['laboratory_test_id']);
        });

        Schema::dropIfExists('scene_actor_lab_results');
    }
};
