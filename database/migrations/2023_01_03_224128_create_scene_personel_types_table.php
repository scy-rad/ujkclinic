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
      Schema::create('scene_personel_types', function (Blueprint $table) {
        $table->id();
        $table->string('spt_name');
        $table->string('spt_name_w');
        $table->string('spt_name_en');
        $table->string('spt_short');
        $table->string('spt_short_en');
        $table->string('spt_description');
        $table->string('spt_code');
        $table->string('spt_color');
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
      Schema::dropIfExists('scene_personel_types');
    }
};
