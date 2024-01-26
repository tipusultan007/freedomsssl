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
    Schema::table('savings_collections', function (Blueprint $table) {
      // Add foreign key constraint to link with daily_savings table
      $table->foreign('daily_savings_id')
        ->references('id')->on('daily_savings')
        ->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::table('savings_collections', function (Blueprint $table) {
      // Drop the foreign key constraint if needed
      $table->dropForeign(['daily_savings_id']);
    });
  }
};
