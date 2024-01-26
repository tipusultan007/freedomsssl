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
        Schema::create('closing_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('user_id')->index('closing_accounts_user_id_foreign');
            $table->string('type')->nullable();
            $table->integer('deposit')->nullable();
            $table->integer('withdraw')->nullable();
            $table->integer('remain')->nullable();
            $table->integer('profit')->nullable();
            $table->integer('service_charge')->nullable();
            $table->integer('total')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('created_by')->index('closing_accounts_created_by_foreign');
            $table->unsignedBigInteger('daily_savings_id')->nullable()->index('closing_accounts_daily_savings_id_foreign');
            $table->unsignedBigInteger('dps_id')->nullable()->index('closing_accounts_dps_id_foreign');
            $table->unsignedBigInteger('special_dps_id')->nullable()->index('closing_accounts_special_dps_id_foreign');
            $table->unsignedBigInteger('fdr_id')->nullable()->index('closing_accounts_fdr_id_foreign');
            $table->string('trx_id', 20);
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
        Schema::dropIfExists('closing_accounts');
    }
};
