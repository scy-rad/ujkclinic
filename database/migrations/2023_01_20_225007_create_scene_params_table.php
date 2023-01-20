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
        Schema::create('scene_params', function (Blueprint $table) {
            $table->id();
            $table->Integer('lab_take_seconds_from')->default(10);
            $table->Integer('lab_take_seconds_to')->default(60);
            $table->Integer('lab_delivery_seconds_from')->default(115);
            $table->Integer('lab_delivery_seconds_to')->default(235);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scene_params');
    }
};
