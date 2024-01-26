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
        Schema::create('dps_loan_interests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('taken_loan_id');
            $table->bigInteger('dps_installment_id');
            $table->string('account_no');
            $table->integer('installments');
            $table->integer('interest');
            $table->integer('total');
            $table->string('month');
            $table->string('year');
            $table->date('date');
            $table->string('status', 11)->default('paid');
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
        Schema::dropIfExists('dps_loan_interests');
    }
};
