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
        Schema::create('special_dps_package_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('special_dps_package_id')->index('special_dps_package_values_special_dps_package_id_foreign');
            $table->double('year', 8, 2);
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
        Schema::dropIfExists('special_dps_package_values');
    }
};
