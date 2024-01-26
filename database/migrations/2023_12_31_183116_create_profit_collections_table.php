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
        Schema::create('profit_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fdr_deposit_id');
            $table->bigInteger('fdr_profit_id')->nullable();
            $table->bigInteger('fdr_id');
            $table->string('account_no');
            $table->integer('installments');
            $table->integer('profit');
            $table->integer('total');
            $table->string('month');
            $table->integer('year');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profit_collections');
    }
};
