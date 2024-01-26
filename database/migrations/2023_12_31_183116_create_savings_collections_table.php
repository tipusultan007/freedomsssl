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
      Schema::create('savings_collections', function (Blueprint $table) {
        $table->id();
        $table->string('account_no');
        $table->unsignedBigInteger('daily_savings_id');
        $table->foreign('daily_savings_id')->references('id')->on('daily_savings')->onDelete('cascade');
        $table->integer('saving_amount');
        $table->string('type');
        $table->integer('collector_id');
        $table->date('date');
        $table->integer('late_fee')->nullable();
        $table->integer('other_fee')->nullable();
        $table->integer('balance');
        $table->decimal('total', 10)->default(0);
        $table->string('trx_id')->nullable();
        $table->integer('user_id');
        $table->timestamps();
        $table->softDeletes();
        $table->unsignedBigInteger('manager_id')->nullable();
        $table->date('collection_date')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savings_collections');
    }
};
