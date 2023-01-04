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
      scene_status -  1: użytkownik aktywny;
                      2: użytkownik nieaktywny;
      */
        Schema::create('scene_personels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scene_master_id');
            $table->unsignedBigInteger('user_id');
            $table->string('scene_personel_name');
            $table->unsignedBigInteger('scene_personel_type_id');
            $table->smallInteger('scene_personel_status')->default(1); 
            $table->timestamps();
        });
        Schema::table('scene_personels', function (Blueprint $table) {
          $table->foreign('scene_master_id')
              ->references('id')
              ->on('scene_masters');
        });
        Schema::table('scene_personels', function (Blueprint $table) {
          $table->foreign('user_id')
              ->references('id')
              ->on('users');
        });
        Schema::table('scene_personels', function (Blueprint $table) {
          $table->foreign('scene_personel_type_id')
              ->references('id')
              ->on('scene_personel_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('scene_personels', function (Blueprint $table) {
        $table->dropForeign(['scene_master_id']);
        });
      Schema::table('scene_personels', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        });
      Schema::table('scene_personels', function (Blueprint $table) {
        $table->dropForeign(['scene_personel_type_id']);
        });  
      Schema::dropIfExists('scene_personels');
    }
};
