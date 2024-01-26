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
        Schema::create('fdr_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('amount');
            $table->integer('one')->default(0);
            $table->integer('two')->default(0);
            $table->integer('three')->default(0);
            $table->integer('four')->default(0);
            $table->integer('five')->default(0);
            $table->integer('five_half')->default(0);
            $table->integer('six')->default(0);
            $table->integer('six_half')->nullable();
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
        Schema::dropIfExists('fdr_packages');
    }
};
