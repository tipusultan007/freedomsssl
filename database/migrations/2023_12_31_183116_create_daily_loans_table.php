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
        Schema::create('daily_loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('daily_loans_user_id_foreign');
            $table->string('account_no', 30);
            $table->unsignedBigInteger('package_id')->index('daily_loans_package_id_foreign');
            $table->integer('per_installment')->nullable()->default(11);
            $table->date('opening_date');
            $table->integer('interest')->nullable();
            $table->integer('adjusted_amount')->nullable();
            $table->date('commencement');
            $table->integer('loan_amount');
            $table->integer('total')->nullable()->default(0);
            $table->integer('balance')->nullable()->default(0);
            $table->integer('grace')->nullable()->default(0);
            $table->integer('paid_interest')->nullable()->default(0);
            $table->date('application_date')->nullable();
            $table->string('status');
            $table->string('note', 255)->nullable();
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
        Schema::dropIfExists('daily_loans');
    }
};
