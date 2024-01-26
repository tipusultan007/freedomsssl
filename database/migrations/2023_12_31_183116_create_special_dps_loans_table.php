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
        Schema::create('special_dps_loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('user_id')->index('special_dps_loans_user_id_foreign');
            $table->integer('loan_amount');
            $table->double('interest1', 8, 2);
            $table->double('interest2', 8, 2)->nullable();
            $table->integer('upto_amount')->nullable();
            $table->date('application_date')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable()->index('special_dps_loans_approved_by_foreign');
            $table->date('opening_date');
            $table->date('commencement');
            $table->string('status')->default('active');
            $table->unsignedBigInteger('created_by')->index('special_dps_loans_created_by_foreign');
            $table->integer('total_paid')->nullable()->default(0);
            $table->integer('paid_interest')->default(0);
            $table->integer('remain_loan')->nullable();
            $table->integer('installment')->nullable();
            $table->integer('dueInterest')->default(0);
            $table->integer('grace')->default(0);
            $table->string('note', 255)->nullable();
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
        Schema::dropIfExists('special_dps_loans');
    }
};
