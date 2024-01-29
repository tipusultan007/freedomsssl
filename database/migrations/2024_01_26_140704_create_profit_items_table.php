<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profit_items', function (Blueprint $table) {
            $table->id();
            $table->string('account_no');
            $table->enum('type',['daily','dps','special']);
            $table->integer('profit')->default(0);
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
        Schema::dropIfExists('profit_items');
    }
};
