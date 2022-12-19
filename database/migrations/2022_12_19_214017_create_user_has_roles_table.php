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
        Schema::create('user_has_roles', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('user_id');
          $table->unsignedBigInteger('role_id');
          $table->timestamps();
        });

        Schema::table('user_has_roles', function (Blueprint $table) {
          $table->foreign('user_id')
              ->references('id')
              ->on('users');
      });

      Schema::table('user_has_roles', function (Blueprint $table) {
          $table->foreign('role_id')
              ->references('id')
              ->on('user_roles');
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_has_roles', function (Blueprint $table) {
          $table->dropForeign(['user_id']);
          });
        Schema::table('user_has_roles', function (Blueprint $table) {
          $table->dropForeign(['role_id']);
          });
        Schema::dropIfExists('user_has_roles');
    }
};
