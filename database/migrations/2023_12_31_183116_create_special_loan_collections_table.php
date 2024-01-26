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
        Schema::create('special_loan_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('user_id')->index('special_loan_collections_user_id_foreign');
            $table->unsignedBigInteger('special_dps_loan_id')->index('special_loan_collections_dps_loan_id_foreign');
            $table->unsignedBigInteger('collector_id')->index('special_loan_collections_collector_id_foreign');
            $table->unsignedBigInteger('special_installment_id')->index('special_loan_collections_dps_installment_id_foreign');
            $table->string('trx_id');
            $table->integer('loan_installment')->nullable();
            $table->integer('balance');
            $table->integer('interest')->nullable();
            $table->integer('due_interest')->nullable()->default(0);
            $table->integer('unpaid_interest')->nullable()->default(0);
            $table->date('date');
            $table->string('loan_note', 255)->nullable();
            $table->string('receipt_no')->nullable();
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
        Schema::dropIfExists('special_loan_collections');
    }
};
