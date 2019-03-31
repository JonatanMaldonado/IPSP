<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voto_users', function (Blueprint $table) {
            $table->increments('idvoto_users');
            $table->integer('iduser')->unsigned();
            $table->integer('idencuesta')->unsigned();
            $table->integer('idopcion')->unsigned();
            $table->enum('voto', ['Si', 'No'])->default('No');
            $table->timestamps();
            $table->foreign('iduser')->references('id')->on('users');
            $table->foreign('idencuesta')->references('idencuesta')->on('encuestas');
            $table->foreign('idopcion')->references('idopcion')->on('opciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voto_users');
    }
}
