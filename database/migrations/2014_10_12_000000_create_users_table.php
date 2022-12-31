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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_title_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('about')->default('');
            $table->string('description')->default('');
            $table->string('user_fotka')->default('_user.jpg');
            $table->time('time_begin')->default('7:30');
            $table->tinyInteger('home_todo_module')->default(0);
            $table->tinyInteger('home_own_days')->default(0);
            $table->tinyInteger('home_second_module')->default(0);
            $table->boolean('simmed_notify')->default(1);
            $table->string('password');
            $table->tinyInteger('user_status')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
