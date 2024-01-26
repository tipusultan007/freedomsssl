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
        Schema::create('dps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no')->unique('account_no');
            $table->unsignedBigInteger('user_id')->index('dps_user_id_foreign');
            $table->integer('introducer_id')->nullable();
            $table->unsignedBigInteger('dps_package_id')->index('dps_dps_package_id_foreign');
            $table->bigInteger('receipt_book')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('package_amount')->nullable();
            $table->integer('principal_profit')->nullable();
            $table->integer('balance')->default(0);
            $table->integer('profit')->default(0);
            $table->integer('total')->default(0);
            $table->string('status')->default('active');
            $table->unsignedBigInteger('created_by')->index('dps_created_by_foreign');
            $table->date('opening_date');
            $table->date('commencement')->nullable();
            $table->string('note', 255)->nullable();
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
        Schema::dropIfExists('dps');
    }
};
