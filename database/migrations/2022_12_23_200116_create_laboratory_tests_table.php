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
      lt_result_type = 1 -> wynik liczbowy
      lt_result_type = 2 -> wynik opisowy
      */
        Schema::create('laboratory_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laboratory_test_group_id');
            $table->unsignedBigInteger('laboratory_order_id');
            $table->string('lt_name');
            $table->string('lt_name_en');
            $table->string('lt_short');
            $table->string('lt_short_en');
            $table->string('lt_unit');
            $table->string('lt_unit_en');
            $table->Integer('lt_decimal_prec');
            $table->smallInteger('lt_result_type')->default(1);
            $table->smallInteger('lt_sort');
            $table->smallInteger('lt_time');
            $table->smallInteger('lt_coast');
            $table->smallInteger('lt_time_cito');
            $table->smallInteger('lt_coast_cito');
            $table->timestamps();
        });
        Schema::table('laboratory_tests', function (Blueprint $table) {
          $table->foreign('laboratory_test_group_id')
              ->references('id')
              ->on('laboratory_test_groups');
        });
        Schema::table('laboratory_tests', function (Blueprint $table) {
          $table->foreign('laboratory_order_id')
              ->references('id')
              ->on('laboratory_orders');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('laboratory_tests', function (Blueprint $table) {
        $table->dropForeign(['laboratory_test_group_id']);
        });
      Schema::table('laboratory_tests', function (Blueprint $table) {
        $table->dropForeign(['laboratory_order_id']);
        });
      Schema::dropIfExists('laboratory_tests');
    }
};
