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
        Schema::create('lab_result_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_order_template_id');
            $table->unsignedBigInteger('laboratory_test_id');
            $table->Integer('lrtr_result')->nullable()->default(null);
            $table->string('lrtr_resulttxt')->nullable()->default(null);
            $table->string('lrtr_addedtext')->nullable()->default(null);
            $table->smallInteger('lrtr_type')->default(1);
            $table->smallInteger('lrtr_sort')->default(1);            
            $table->timestamps();
        });
        Schema::table('lab_result_templates', function (Blueprint $table) {
          $table->foreign('lab_order_template_id')
              ->references('id')
              ->on('lab_order_templates');
        });
        Schema::table('lab_result_templates', function (Blueprint $table) {
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
        Schema::table('lab_result_templates', function (Blueprint $table) {
          $table->dropForeign(['lab_order_template_id']);
          });
        Schema::table('lab_result_templates', function (Blueprint $table) {
          $table->dropForeign(['laboratory_test_id']);
          }); 
        Schema::dropIfExists('lab_result_templates');
    }
};
