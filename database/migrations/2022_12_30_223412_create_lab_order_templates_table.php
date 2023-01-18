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
      lrt_type:   1:  template for previous laboratory test
                  2:  template for future laboratory test
      */

        Schema::create('lab_order_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id')->nullable();
            $table->string('description_for_leader');
            $table->Integer('lrt_minutes_before')->default(0);
            $table->smallInteger('lrt_type')->default(2);
            $table->smallInteger('lrt_sort')->default(1);
            $table->timestamps();
        });
        Schema::table('lab_order_templates', function (Blueprint $table) {
          $table->foreign('actor_id')
              ->references('id')
              ->on('actors');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lab_order_templates', function (Blueprint $table) {
          $table->dropForeign(['actor_id']);
          });
        Schema::dropIfExists('lab_order_templates');
    }
};
