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
        Schema::create('dps_package_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dps_package_id')->nullable()->index('dps_package_values_dps_package_id_foreign');
            $table->integer('year');
            $table->integer('amount');
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
        Schema::dropIfExists('dps_package_values');
    }
};
