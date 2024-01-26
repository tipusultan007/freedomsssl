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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('workplace')->nullable();
            $table->string('occupation')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('national_id')->nullable();
            $table->string('nationality', 15)->nullable()->default('Bangladeshi');
            $table->string('birth_id')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->default('other');
            $table->date('birthdate')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('marital_status', 11)->nullable()->default('married');
            $table->string('spouse_name', 255)->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
            $table->integer('wallet')->default(0);
            $table->date('join_date')->nullable()->default('2022-08-27');
            $table->rememberToken();
            $table->unsignedBigInteger('current_team_id')->nullable();
            $table->string('image', 2048)->nullable();
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
        Schema::dropIfExists('users');
    }
};
