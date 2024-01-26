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
        Schema::create('special_loan_interests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('special_loan_taken_id');
            $table->bigInteger('special_installment_id');
            $table->string('account_no');
            $table->integer('installments');
            $table->integer('interest');
            $table->integer('total');
            $table->string('month');
            $table->string('year');
            $table->date('date');
            $table->string('status', 11)->default('paid');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('special_loan_interests');
    }
};
