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
        Schema::create('scene_types', function (Blueprint $table) {
            $table->id();
            $table->string('scene_type_code');
            $table->string('scene_type_name');
            $table->string('scene_type_blade');
            $table->string('scene_type_descript');
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
        Schema::dropIfExists('scene_types');
    }
};
