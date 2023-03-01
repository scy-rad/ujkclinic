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
        Schema::create('scenario_consultation_templates', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('character_id')->nullable();
          $table->string('sct_name');
          $table->Integer('sct_minutes_before')->nullable();
          $table->Integer('sct_seconds_description')->default(0);
          $table->string('sct_verbal_attach')->nullable();
          $table->string('sct_description');
          $table->timestamps();
      });
      Schema::table('scenario_consultation_templates', function (Blueprint $table) {
        $table->foreign('character_id')
            ->references('id')
            ->on('characters');
      });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('scenario_consultation_templates', function (Blueprint $table) {
      $table->dropForeign(['character_id']);
      });
    Schema::dropIfExists('scenario_consultation_templates');
  }
};
