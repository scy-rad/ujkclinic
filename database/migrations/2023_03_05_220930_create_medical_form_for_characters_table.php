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
        Schema::create('medical_form_for_characters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_id');
            $table->Integer('mf_minutes_before_1')->nullable();
            $table->Integer('mf_minutes_before_2')->nullable();
            $table->Integer('mf_minutes_before_3')->nullable();
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
        Schema::table('medical_form_for_characters', function (Blueprint $table) {
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
        Schema::table('medical_form_for_characters', function (Blueprint $table) {
          $table->dropForeign(['character_id']);
          });
        Schema::dropIfExists('medical_form_for_characters');
    }
};
