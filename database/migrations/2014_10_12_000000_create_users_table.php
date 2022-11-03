<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('country_code', 64)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('state', 64)->nullable();
            $table->string('cap', 64)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('street', 255)->nullable();
            $table->string('street_nr', 64)->nullable();
            $table->string('vat_nr', 64)->nullable();
            $table->string('cf', 64)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('surname', 255)->nullable();
            $table->string('pec', 255)->nullable();
            $table->string('tel', 64)->nullable();
            $table->string('web', 255)->nullable();
            $table->string('bank_iban', 64)->nullable();
            $table->string('bank_bic', 64)->nullable();
            $table->string('bank_name', 255)->nullable();
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
}
