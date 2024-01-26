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
        Schema::create('dps_loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('user_id')->index('dps_loans_user_id_foreign');
            $table->integer('loan_amount');
            $table->double('interest1', 8, 2);
            $table->double('interest2', 8, 2)->nullable();
            $table->integer('upto_amount')->nullable();
            $table->date('application_date')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable()->index('dps_loans_approved_by_foreign');
            $table->date('opening_date')->nullable();
            $table->date('commencement');
            $table->string('status');
            $table->unsignedBigInteger('created_by')->index('dps_loans_created_by_foreign');
            $table->integer('total_paid')->nullable()->default(0);
            $table->integer('remain_loan')->nullable()->default(0);
            $table->integer('installment')->nullable();
            $table->integer('paid_interest')->nullable()->default(0);
            $table->integer('grace')->nullable()->default(0);
            $table->string('note', 255)->nullable();
            $table->integer('dueInterest')->nullable();
            $table->json('dueInstallment')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('dps_loans');
    }
};
