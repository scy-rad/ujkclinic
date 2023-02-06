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
      // scta_type: - 1: Image
      //            - 9: Other
        Schema::create('scenario_consultation_template_attachments', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('sct_id')->nullable();
          $table->string('scta_file');
          $table->string('scta_type');
          $table->string('scta_name');
          $table->Integer('scta_seconds_attachments')->default(0);
          $table->timestamps();
      });
      Schema::table('scenario_consultation_template_attachments', function (Blueprint $table) {
        $table->foreign('sct_id')
            ->references('id')
            ->on('scenario_consultation_templates');
      });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::table('scenario_consultation_template_attachments', function (Blueprint $table) {
        $table->dropForeign(['sct_id']);
        });
      Schema::dropIfExists('scenario_consultation_template_attachments');
  }
};
