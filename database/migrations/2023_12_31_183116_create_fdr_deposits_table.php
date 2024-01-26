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
        Schema::create('fdr_deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no')->nullable();
            $table->unsignedBigInteger('fdr_id')->index('fdr_deposits_fdr_id_foreign');
            $table->unsignedBigInteger('user_id')->nullable()->index('fdr_deposits_user_id_foreign');
            $table->integer('amount');
            $table->unsignedBigInteger('fdr_package_id')->index('fdr_deposits_fdr_package_id_foreign');
            $table->date('date');
            $table->date('commencement');
            $table->integer('balance')->default(0);
            $table->integer('profit')->nullable();
            $table->string('trx_id')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('fdr_deposits_created_by_foreign');
            $table->string('note')->nullable();
            $table->string('deposited_via', 11)->default('cash');
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
        Schema::dropIfExists('fdr_deposits');
    }
};
