<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('special_dps_completes', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('user_id');
      $table->bigInteger('special_dps_id');
      $table->bigInteger('special_dps_loan_id');
      $table->string('account_no');
      $table->integer('withdraw');
      $table->integer('profit')->default(0);
      $table->integer('remain')->default(0);
      $table->integer('loan_payment')->default(0);
      $table->integer('interest')->default(0);
      $table->integer('grace')->default(0);
      $table->integer('service_fee')->default(0);
      $table->date('date');
      $table->integer('manager_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('special_dps_completes');
  }
};
