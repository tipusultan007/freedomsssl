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
        Schema::create('daily_savings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no', 20);
            $table->unsignedBigInteger('user_id')->index('daily_savings_user_id_foreign');
            $table->date('opening_date');
            $table->integer('deposit')->nullable()->default(0);
            $table->integer('withdraw')->nullable()->default(0);
            $table->integer('profit')->nullable()->default(0);
            $table->integer('total')->nullable()->default(0);
            $table->unsignedBigInteger('introducer_id')->nullable()->index('daily_savings_introducer_id_foreign');
            $table->string('status', 15)->default('active');
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
        Schema::dropIfExists('daily_savings');
    }
};
