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
        Schema::create('taken_loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('user_id')->index('taken_loans_user_id_foreign');
            $table->integer('loan_amount');
            $table->integer('remain')->nullable();
            $table->integer('before_loan')->nullable();
            $table->integer('after_loan')->nullable();
            $table->double('interest1', 8, 2);
            $table->double('interest2', 8, 2)->nullable();
            $table->integer('upto_amount')->nullable();
            $table->date('date');
            $table->date('commencement');
            $table->unsignedBigInteger('created_by')->index('taken_loans_created_by_foreign');
            $table->unsignedBigInteger('dps_loan_id')->index('taken_loans_dps_loan_id_foreign');
            $table->string('bank_name', 255)->nullable();
            $table->string('branch_name', 255)->nullable();
            $table->string('cheque_no', 255)->nullable();
            $table->text('documents')->nullable();
            $table->string('documents_note', 255)->nullable();
            $table->integer('installment')->nullable();
            $table->string('note', 255)->nullable();
            $table->string('trx_id')->nullable();
            $table->string('status', 15)->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('is_sms_sent')->default(false);
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
        Schema::dropIfExists('taken_loans');
    }
};
