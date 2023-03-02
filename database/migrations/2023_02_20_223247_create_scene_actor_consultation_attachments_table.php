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
      // saca_type: - 1: Image
      //            - 9: Other
        Schema::create('scene_actor_consultation_attachments', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('sac_id');
          $table->string('saca_file');
          $table->string('saca_type')->default('typ');
          $table->string('saca_name')->default('')->nullable();
          $table->dateTime('saca_date')->nullable();
          $table->timestamps();
      });
      Schema::table('scene_actor_consultation_attachments', function (Blueprint $table) {
        $table->foreign('sac_id')
            ->references('id')
            ->on('scene_actor_consultations');
      });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::table('scene_actor_consultation_attachments', function (Blueprint $table) {
        $table->dropForeign(['sac_id']);
        });
      Schema::dropIfExists('scene_actor_consultation_attachments');
  }
};
