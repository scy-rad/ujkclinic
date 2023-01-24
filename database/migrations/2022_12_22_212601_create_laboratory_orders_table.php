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
        Schema::create('laboratory_orders', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('laboratory_order_group_id');
          $table->string('lo_name');
          $table->string('lo_name_en');
          $table->boolean('lo_break')->default(0);
          $table->Integer('lo_sort');
          $table->timestamps();
      });
      Schema::table('laboratory_orders', function (Blueprint $table) {
        $table->foreign('laboratory_order_group_id')
            ->references('id')
            ->on('laboratory_order_groups');
      });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('laboratory_orders', function (Blueprint $table) {
      $table->dropForeign(['laboratory_order_group_id']);
      });
    Schema::dropIfExists('laboratory_orders');
  }
};
