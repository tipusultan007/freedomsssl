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
        Schema::create('special_dps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no')->unique('account_no');
            $table->unsignedBigInteger('user_id')->index('special_dps_user_id_foreign');
            $table->unsignedBigInteger('special_dps_package_id')->index('special_dps_special_dps_package_id_foreign');
            $table->integer('initial_amount')->default(0);
            $table->integer('balance')->default(0);
            $table->unsignedBigInteger('created_by')->nullable()->index('special_dps_created_by_foreign');
            $table->string('status')->default('active');
            $table->date('opening_date');
            $table->date('commencement')->nullable();
            $table->timestamps();
            $table->integer('package_amount')->nullable();
            $table->integer('principal_profit')->nullable();
            $table->integer('introducer_id')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('receipt_book')->nullable();
            $table->string('notes', 255)->nullable();
            $table->string('trx_id', 36);
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
        Schema::dropIfExists('special_dps');
    }
};
