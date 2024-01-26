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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id')->nullable()->index('transactions_account_id_foreign');
            $table->unsignedBigInteger('user_id')->nullable()->index('transactions_user_id_foreign');
            $table->string('description')->nullable();
            $table->string('account_no', 10)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('trx_id')->nullable();
            $table->date('date');
            $table->decimal('amount', 10);
            $table->timestamps();
            $table->string('interest_type', 15)->nullable();
            $table->string('type', 15)->nullable();
            $table->bigInteger('transactionable_id')->nullable();
            $table->string('transactionable_type', 255)->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
