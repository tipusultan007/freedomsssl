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
        Schema::create('loan_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_no');
            $table->string('document_name')->nullable();
            $table->string('document_location')->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger('collect_by')->nullable()->index('loan_documents_collect_by_foreign');
            $table->unsignedBigInteger('taken_loan_id')->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->string('branch_name', 255)->nullable();
            $table->string('cheque_no', 30)->nullable();
            $table->timestamps();
            $table->integer('daily_loan_id')->nullable();
            $table->integer('special_taken_loan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_documents');
    }
};
