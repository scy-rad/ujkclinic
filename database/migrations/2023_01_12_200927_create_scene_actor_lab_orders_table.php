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
        Schema::create('scene_actor_lab_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scene_actor_id');
            $table->boolean('salo_cito')->default(0);
            $table->dateTime('salo_date_order');
            $table->dateTime('salo_date_take')->nullable();
            $table->dateTime('salo_date_delivery')->nullable();
            $table->dateTime('salo_date_accept')->nullable();
            $table->string('salo_descript')->nullable();
            $table->string('salo_diagnostician');
            $table->timestamps();
        });

        Schema::table('scene_actor_lab_orders', function (Blueprint $table) {
          $table->foreign('scene_actor_id')
              ->references('id')
              ->on('scene_actors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('scene_actor_lab_orders', function (Blueprint $table) {
        $table->dropForeign(['scene_actor_id']);
        });

        Schema::dropIfExists('scene_actor_lab_orders');
    }
};
