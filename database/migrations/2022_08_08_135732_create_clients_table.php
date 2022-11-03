<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('country_code', 64);
            $table->string('country', 255);
            $table->string('state', 64)->nullable();
            $table->string('cap', 64);
            $table->string('city', 255);
            $table->string('street', 255);
            $table->string('street_nr', 64);
            $table->string('vat_nr', 64)->nullable();
            $table->string('cf', 64)->nullable();
            $table->string('destination_code', 7)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('surname', 255)->nullable();
            $table->string('display_name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('pec', 255)->nullable();
            $table->string('template', 64)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
