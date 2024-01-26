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
        Schema::create('fdrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no')->unique('account_no');
            $table->unsignedBigInteger('user_id')->index('fdrs_user_id_foreign');
            $table->date('date');
            $table->integer('amount')->nullable();
            $table->integer('balance')->default(0);
            $table->integer('profit')->default(0);
            $table->date('commencement');
            $table->string('note')->nullable();
            $table->integer('introducer_id')->nullable();
            $table->string('status', 20)->default('active');
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('fdrs');
    }
};
