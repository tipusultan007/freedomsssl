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
        Schema::create('fdr_profits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('user_id')->index('fdr_profits_user_id_foreign');
            $table->unsignedBigInteger('fdr_id')->index('fdr_profits_fdr_id_foreign');
            $table->integer('profit');
            $table->integer('balance')->nullable();
            $table->integer('other_fee')->nullable();
            $table->integer('grace')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('created_by')->index('fdr_profits_created_by_foreign');
            $table->string('trx_id');
            $table->enum('month', ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])->nullable();
            $table->year('year')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('fdr_profits');
    }
};
