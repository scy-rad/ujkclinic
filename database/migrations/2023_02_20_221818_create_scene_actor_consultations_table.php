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
        Schema::create('scene_actor_consultations', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('scene_actor_id')->nullable();
          $table->unsignedBigInteger('cont_id');
          $table->string('sac_type_details');
          $table->string('sac_reason');
          $table->dateTime('sac_date_order');
          $table->dateTime('sac_date_visit')->nullable();
          $table->dateTime('sac_date_descript')->nullable();
          $table->string('sac_verbal_attach')->nullable();
          $table->string('sac_description')->nullable();
          $table->timestamps();
      });
      Schema::table('scene_actor_consultations', function (Blueprint $table) {
        $table->foreign('scene_actor_id')
            ->references('id')
            ->on('scene_actors');
      });
      Schema::table('scene_actor_consultations', function (Blueprint $table) {
        $table->foreign('cont_id')
            ->references('id')
            ->on('consultation_types');
      });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('scene_actor_consultations', function (Blueprint $table) {
      $table->dropForeign(['cont_id']);
      });
    Schema::table('scene_actor_consultations', function (Blueprint $table) {
      $table->dropForeign(['scene_actor_id']);
      });
    Schema::dropIfExists('scene_actor_consultations');
  }
};
