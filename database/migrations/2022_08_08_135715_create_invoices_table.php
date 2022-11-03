<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number', 64);
            $table->date('date')->nullable();
            $table->string('currency', 64)->nullable();
            $table->foreignId('client_id');
            $table->string('subtotal', 64)->nullable();
            $table->string('stamp', 64)->nullable();
            $table->string('provision', 64)->nullable();
            $table->string('discount', 64)->nullable();
            $table->string('total', 64)->nullable();
            $table->string('total_rounded', 64)->nullable();
            $table->string('exchange_rate', 64)->nullable();
            $table->string('total_eur', 64)->nullable();
            $table->integer('paid')->nullable();
            $table->integer('upload_xml')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
