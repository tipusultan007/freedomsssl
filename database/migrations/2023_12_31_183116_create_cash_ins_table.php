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
        Schema::create('cash_ins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('daily_collection_id')->nullable();
            $table->bigInteger('dps_installment_id')->nullable();
            $table->bigInteger('special_installment_id')->nullable();
            $table->bigInteger('frd_deposit_id')->nullable();
            $table->integer('special_dps_id')->nullable();
            $table->unsignedBigInteger('user_id')->index('cash_ins_user_id_foreign');
            $table->unsignedBigInteger('cashin_category_id')->index('cash_ins_cashin_category_id_foreign');
            $table->string('account_no');
            $table->double('amount');
            $table->string('trx_id')->nullable();
            $table->string('description')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('cash_ins');
    }
};
