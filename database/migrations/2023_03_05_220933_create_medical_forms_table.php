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
        Schema::create('medical_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_center_visit_card_id');
            $table->unsignedBigInteger('medical_form_type_id');
            $table->dateTime('mf_date_1');
            $table->dateTime('mf_date_2')->nullable();
            $table->dateTime('mf_date_3')->nullable();
            $table->Integer('mf_integer_1')->nullable();
            $table->Integer('mf_integer_2')->nullable();            
            $table->Integer('mf_integer_3')->nullable();
            $table->float('mf_float_1')->nullable();
            $table->float('mf_float_2')->nullable();
            $table->float('mf_float_3')->nullable();
            $table->string('mf_string_1')->nullable();
            $table->string('mf_string_2')->nullable();
            $table->string('mf_string_3')->nullable();
            $table->text('mf_text_1')->nullable();
            $table->text('mf_text_2')->nullable();
            $table->text('mf_text_3')->nullable();
            $table->timestamps();
        });
        Schema::table('medical_forms', function (Blueprint $table) {
          $table->foreign('medical_center_visit_card_id')
              ->references('id')
              ->on('medical_center_visit_cards');
        });
        Schema::table('medical_forms', function (Blueprint $table) {
          $table->foreign('medical_form_type_id')
              ->references('id')
              ->on('medical_form_types');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_forms', function (Blueprint $table) {
          $table->dropForeign(['medical_center_visit_card_id']);
          });
        Schema::table('medical_forms', function (Blueprint $table) {
          $table->dropForeign(['medical_form_type_id']);
          });
        Schema::dropIfExists('medical_forms');
    }
};
