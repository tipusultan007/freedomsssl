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
        Schema::create('fdr_withdraws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no')->nullable();
            $table->integer('fdr_package_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('fdr_withdraws_user_id_foreign');
            $table->unsignedBigInteger('fdr_id')->index('fdr_withdraws_fdr_id_foreign');
            $table->date('date');
            $table->unsignedBigInteger('fdr_deposit_id')->index('fdr_withdraws_fdr_deposit_id_foreign');
            $table->integer('amount');
            $table->string('note')->nullable();
            $table->unsignedBigInteger('created_by')->index('fdr_withdraws_created_by_foreign');
            $table->integer('balance');
            $table->string('trx_id')->nullable();
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
        Schema::dropIfExists('fdr_withdraws');
    }
};
