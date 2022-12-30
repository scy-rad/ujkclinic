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
        Schema::create('laboratory_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laboratory_test_group_id');
            $table->string('lt_name');
            $table->string('lt_name_en');
            $table->string('lt_short');
            $table->string('lt_short_en');
            $table->smallInteger('lt_level');
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
      Schema::dropIfExists('laboratory_tests');
    }
};
