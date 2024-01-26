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
        Schema::create('daily_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('user_id')->index('daily_collections_user_id_foreign');
            $table->unsignedBigInteger('collector_id')->nullable()->index('daily_collections_collector_id_foreign');
            $table->integer('created_by')->nullable();
            $table->integer('saving_amount')->nullable();
            $table->string('saving_type')->nullable();
            $table->integer('late_fee')->nullable();
            $table->integer('other_fee')->nullable();
            $table->integer('loan_installment')->nullable();
            $table->integer('loan_late_fee')->nullable();
            $table->integer('loan_other_fee')->nullable();
            $table->string('saving_note')->nullable();
            $table->string('loan_note')->nullable();
            $table->unsignedBigInteger('daily_savings_id')->nullable()->index('daily_collections_daily_savings_id_foreign');
            $table->unsignedBigInteger('daily_loan_id')->nullable()->index('daily_collections_daily_loan_id_foreign');
            $table->integer('savings_balance')->nullable();
            $table->integer('loan_balance')->nullable();
            $table->date('date');
            $table->date('collection_date')->nullable();
            $table->integer('grace')->default(0);
            $table->string('trx_id')->nullable();
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
        Schema::dropIfExists('daily_collections');
    }
};
