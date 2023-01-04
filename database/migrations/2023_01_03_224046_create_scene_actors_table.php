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
        Schema::create('scene_actors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scene_master_id');
            $table->unsignedBigInteger('actor_id')->nullable();
            $table->dateTime('sa_birth_date');
            $table->string('sa_PESEL',11);
            $table->smallInteger('sa_actor_sex');  // 2 - mężczyzna,  3 - kobieta
            $table->string('sa_actor_role_name');
            $table->text('sa_history_for_actor');
            $table->text('sa_actor_simulation');
            $table->timestamps();
        });
        Schema::table('scene_actors', function (Blueprint $table) {
          $table->foreign('scene_master_id')
              ->references('id')
              ->on('scene_masters');
        });
        Schema::table('scene_actors', function (Blueprint $table) {
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
      Schema::table('scene_actors', function (Blueprint $table) {
        $table->dropForeign(['scene_master_id']);
        });
      Schema::table('scene_actors', function (Blueprint $table) {
        $table->dropForeign(['actor_id']);
        });
      Schema::dropIfExists('scene_actors');
    }
};
