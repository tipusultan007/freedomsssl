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
        Schema::create('adjust_amounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('loan_id')->index('adjust_amounts_loan_id_foreign');
            $table->unsignedBigInteger('daily_loan_id')->index('adjust_amounts_daily_loan_id_foreign');
            $table->integer('adjust_amount');
            $table->integer('before_adjust');
            $table->integer('after_adjust');
            $table->date('date');
            $table->unsignedBigInteger('added_by')->index('adjust_amounts_added_by_foreign');
            $table->timestamps();
            $table->integer('manager_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjust_amounts');
    }
};
