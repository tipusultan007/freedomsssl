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
        Schema::create('daily_loan_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('daily_loan_id')->index('daily_loan_collections_daily_loan_id_foreign');
            $table->integer('loan_installment');
            $table->integer('installment_no')->nullable()->default(0);
            $table->integer('loan_late_fee')->nullable();
            $table->integer('loan_other_fee')->nullable();
            $table->string('loan_note')->nullable();
            $table->integer('loan_balance');
            $table->unsignedBigInteger('collector_id')->index('daily_loan_collections_collector_id_foreign');
            $table->integer('created_by')->nullable();
            $table->string('trx_id', 40)->nullable();
            $table->date('date');
            $table->integer('due_interest')->nullable()->default(0);
            $table->unsignedBigInteger('user_id')->index('daily_loan_collections_user_id_foreign');
            $table->timestamps();
            $table->integer('manager_id')->nullable();
            $table->date('collection_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_loan_collections');
    }
};
