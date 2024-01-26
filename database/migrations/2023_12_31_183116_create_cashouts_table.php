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
        Schema::create('cashouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('daily_collection_id')->nullable();
            $table->bigInteger('fdr_profit_id')->nullable();
            $table->bigInteger('fdr_withdraw_id')->nullable();
            $table->bigInteger('fdr_deposit_id')->nullable();
            $table->bigInteger('daily_loan_id')->nullable();
            $table->bigInteger('dps_loan_id')->nullable();
            $table->bigInteger('special_loan_id')->nullable();
            $table->unsignedBigInteger('cashout_category_id')->index('cashouts_cashout_category_id_foreign');
            $table->string('account_no');
            $table->double('amount');
            $table->string('trx_id')->nullable();
            $table->text('description')->nullable();
            $table->date('date');
            $table->bigInteger('closing_id')->nullable();
            $table->unsignedBigInteger('user_id')->index('cashouts_user_id_foreign');
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
        Schema::dropIfExists('cashouts');
    }
};
