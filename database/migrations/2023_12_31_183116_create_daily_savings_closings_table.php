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
        Schema::create('daily_savings_closings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('daily_savings_id')->index('daily_savings_closings_daily_savings_id_foreign');
            $table->integer('deposit');
            $table->integer('loan')->default(0);
            $table->integer('grace')->default(0);
            $table->integer('profit')->nullable()->default(0);
            $table->unsignedBigInteger('closing_by')->index('daily_savings_closings_closing_by_foreign');
            $table->date('date');
            $table->integer('service_charge')->default(0);
            $table->timestamps();
            $table->integer('payable')->default(0);
            $table->integer('receivable')->default(0);
            $table->integer('total')->default(0);
            $table->string('trx_id')->nullable();
            $table->integer('daily_loan_id')->nullable();
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
        Schema::dropIfExists('daily_savings_closings');
    }
};
