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
        Schema::create('special_loan_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('special_loan_taken_id');
            $table->bigInteger('special_installment_id');
            $table->integer('amount');
            $table->integer('balance');
            $table->date('date');
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
        Schema::dropIfExists('special_loan_payments');
    }
};
