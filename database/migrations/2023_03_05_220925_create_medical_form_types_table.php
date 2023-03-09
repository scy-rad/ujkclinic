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
        Schema::create('medical_form_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_form_familly_id');
            $table->string('mft_name');
            $table->string('mft_short');
            $table->string('mft_code');
            $table->string('mft_show_skeleton');
            $table->string('mft_edit_skeleton');
            $table->smallInteger('mft_sort')->default(1);
            $table->timestamps();
        });
        Schema::table('medical_form_types', function (Blueprint $table) {
          $table->foreign('medical_form_familly_id')
              ->references('id')
              ->on('medical_form_famillies');
        });
  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('medical_form_types', function (Blueprint $table) {
        $table->dropForeign(['medical_form_familly_id']);
        });
      Schema::dropIfExists('medical_form_types');
    }
};
