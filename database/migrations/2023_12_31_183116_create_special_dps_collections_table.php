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
        Schema::create('special_dps_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->unsignedBigInteger('user_id')->index('special_dps_collections_user_id_foreign');
            $table->unsignedBigInteger('special_dps_id')->index('special_dps_collections_special_dps_id_foreign');
            $table->integer('dps_amount');
            $table->integer('balance');
            $table->enum('month', ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
            $table->year('year');
            $table->date('date');
            $table->unsignedBigInteger('collector_id')->index('special_dps_collections_collector_id_foreign');
            $table->unsignedBigInteger('special_installment_id')->index('special_dps_collections_special_installment_id_foreign');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('special_dps_collections');
    }
};
