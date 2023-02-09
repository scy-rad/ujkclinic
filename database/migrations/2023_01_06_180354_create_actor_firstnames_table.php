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
        Schema::create('character_firstnames', function (Blueprint $table) {
            $table->id();
            $table->string('firstname_man');
            $table->string('firstname_woman');
            $table->integer('count_man');
            $table->integer('count_woman');
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
        Schema::dropIfExists('character_firstnames');
    }
};
