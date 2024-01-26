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
        Schema::create('dps_unpaid_interests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->integer('dps_loan_id');
            $table->string('month');
            $table->string('year');
            $table->integer('interest');
            $table->string('trx_id');
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
        Schema::dropIfExists('dps_unpaid_interests');
    }
};
