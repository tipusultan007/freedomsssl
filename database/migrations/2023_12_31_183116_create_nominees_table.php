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
        Schema::create('nominees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no', 20);
            $table->string('name', 100)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('relation', 20)->nullable();
            $table->integer('percentage')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('nominees_user_id_foreign');
            $table->string('image', 255)->nullable();
            $table->string('name1', 255)->nullable();
            $table->string('address1', 255)->nullable();
            $table->string('phone1', 20)->nullable();
            $table->string('relation1', 20)->nullable();
            $table->integer('percentage1')->nullable();
            $table->date('birthdate1')->nullable();
            $table->string('image1', 255)->nullable();
            $table->integer('user_id1')->nullable();
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
        Schema::dropIfExists('nominees');
    }
};
