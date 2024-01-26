<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
  {
    Schema::table('transactions', function (Blueprint $table) {
      // Add foreign key constraint to link with savings_collections table
      $table->foreign('transactionable_id')
        ->references('id')->on('savings_collections')
        ->onDelete('cascade');

      $table->foreign('transactionable_id')
        ->references('id')->on('daily_savings')
        ->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::table('transactions', function (Blueprint $table) {
      // Drop the foreign key constraints if needed
      $table->dropForeign(['transactionable_id']);
    });
  }
};
