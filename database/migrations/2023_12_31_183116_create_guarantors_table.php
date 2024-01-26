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
        Schema::create('guarantors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index('guarantors_user_id_foreign');
            $table->string('account_no', 30)->nullable();
            $table->string('name')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('address')->nullable();
            $table->string('exist_ac_no')->nullable();
            $table->unsignedBigInteger('daily_loan_id')->nullable()->index('guarantors_daily_loan_id_foreign');
            $table->string('nid', 255)->nullable();
            $table->timestamps();
            $table->integer('taken_loan_id')->nullable();
            $table->integer('special_taken_loan_id')->nullable();
            $table->integer('guarantor_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guarantors');
    }
};
