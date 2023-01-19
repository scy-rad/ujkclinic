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
      /*
      norm type:  1:  mniej niż MIN
                  2:  mniej bądź równo MIN
                  3:  pomiędzy MIN a MAX
                  4:  więcej lub równo MAX
                  5:  więcej niż MAX
                  6:  wynik opisowy 
      */
        Schema::create('laboratory_test_norms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laboratory_test_id');
            $table->Integer('ltn_days_from');
            $table->Integer('ltn_days_to');
            $table->smallInteger('ltn_norm_type');
            
            $table->BigInteger('ltn_norm_m_min')->nullable();
            $table->BigInteger('ltn_norm_m_max')->nullable();
            $table->BigInteger('ltn_norm_w_min')->nullable();
            $table->BigInteger('ltn_norm_w_max')->nullable();
            $table->BigInteger('ltn_norm_p_min')->nullable();
            $table->BigInteger('ltn_norm_p_max')->nullable();

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
        Schema::dropIfExists('laboratory_test_norms');
    }
};
