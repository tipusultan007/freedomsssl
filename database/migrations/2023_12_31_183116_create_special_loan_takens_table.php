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
        Schema::create('special_loan_takens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('user_id')->index('special_loan_takens_user_id_foreign');
            $table->integer('loan_amount');
            $table->integer('remain')->nullable()->default(0);
            $table->integer('before_loan')->nullable();
            $table->integer('after_loan')->nullable();
            $table->double('interest1', 8, 2);
            $table->double('interest2', 8, 2)->nullable();
            $table->integer('upto_amount')->nullable();
            $table->date('date');
            $table->date('commencement');
            $table->unsignedBigInteger('special_dps_loan_id')->index('special_loan_takens_special_dps_loan_id_foreign');
            $table->integer('installment')->nullable();
            $table->string('note', 255)->nullable();
            $table->string('trx_id')->nullable();
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
        Schema::dropIfExists('special_loan_takens');
    }
};
