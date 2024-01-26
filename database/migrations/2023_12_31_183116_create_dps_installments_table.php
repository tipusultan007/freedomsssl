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
        Schema::create('dps_installments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('user_id')->index('dps_installments_user_id_foreign');
            $table->unsignedBigInteger('dps_id')->nullable()->index('dps_installments_dps_id_foreign');
            $table->unsignedBigInteger('dps_loan_id')->nullable()->index('dps_installments_dps_loan_id_foreign');
            $table->integer('dps_amount')->nullable();
            $table->integer('dps_installments')->nullable();
            $table->integer('loan_installments')->nullable();
            $table->integer('dps_balance')->nullable();
            $table->string('receipt_no')->nullable();
            $table->integer('late_fee')->nullable()->default(0);
            $table->integer('other_fee')->nullable()->default(0);
            $table->integer('grace')->nullable()->default(0);
            $table->integer('advance')->nullable()->default(0);
            $table->integer('advance_return')->nullable()->default(0);
            $table->integer('loan_installment')->nullable();
            $table->integer('interest')->nullable();
            $table->integer('installment_no')->nullable();
            $table->string('trx_id');
            $table->integer('loan_balance')->nullable();
            $table->integer('total')->default(0);
            $table->integer('due')->nullable()->default(0);
            $table->integer('due_return')->nullable()->default(0);
            $table->date('date');
            $table->integer('loan_late_fee')->nullable();
            $table->integer('loan_other_fee')->nullable();
            $table->string('dps_note', 255)->nullable();
            $table->string('loan_note', 255)->nullable();
            $table->integer('loan_grace')->nullable()->default(0);
            $table->integer('due_interest')->nullable()->default(0);
            $table->integer('unpaid_interest')->nullable()->default(0);
            $table->string('deposited_via', 11)->nullable()->default('cash');
            $table->text('deposited_via_details')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('dps_installments');
    }
};
