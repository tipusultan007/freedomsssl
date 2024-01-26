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
        Schema::create('add_profits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('daily_savings_id')->index('add_profits_daily_savings_id_foreign');
            $table->unsignedBigInteger('user_id')->index('add_profits_user_id_foreign');
            $table->string('account_no');
            $table->integer('profit');
            $table->integer('before_profit')->default(0);
            $table->integer('after_profit')->default(0);
            $table->date('date');
            $table->string('duration');
            $table->unsignedBigInteger('created_by')->index('add_profits_created_by_foreign');
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
        Schema::dropIfExists('add_profits');
    }
};
