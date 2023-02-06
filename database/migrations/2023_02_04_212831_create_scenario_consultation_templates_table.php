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
          $table->unsignedBigInteger('actor_id')->nullable();
          $table->unsignedBigInteger('sctt_id');
          $table->string('sct_type_details');
          $table->string('sct_reason');
          $table->Integer('sct_minutes_before')->nullable();
          $table->Integer('sct_seconds_description')->default(0);
          $table->string('sct_verbal_attach')->nullable();
          $table->string('sct_description');
          $table->timestamps();
      });
      Schema::table('scenario_consultation_templates', function (Blueprint $table) {
        $table->foreign('actor_id')
            ->references('id')
            ->on('actors');
      });
      Schema::table('scenario_consultation_templates', function (Blueprint $table) {
        $table->foreign('sctt_id')
            ->references('id')
            ->on('scenario_consultation_template_types');
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
      $table->dropForeign(['sctt_id']);
      });
    Schema::table('scenario_consultation_templates', function (Blueprint $table) {
      $table->dropForeign(['actor_id']);
      });
    Schema::dropIfExists('scenario_consultation_templates');
  }
};
