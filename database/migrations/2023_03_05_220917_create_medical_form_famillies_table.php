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
        Schema::create('medical_form_famillies', function (Blueprint $table) {
            $table->id();
            $table->string('mff_name');
            $table->string('mff_short');
            $table->string('mff_code');
            $table->string('mff_icon');
            $table->smallInteger('mff_sort')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_form_famillies');
    }
};
