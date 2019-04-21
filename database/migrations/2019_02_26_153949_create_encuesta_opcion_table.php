<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestaOpcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta_opciones', function (Blueprint $table) {
            $table->increments('idencuesta_opcion');
            $table->integer('idencuesta')->unsigned();
            $table->integer('idopcion')->unsigned();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->foreign('idencuesta')->references('idencuesta')->on('encuestas');
            $table->foreign('idopcion')->references('idopcion')->on('opciones');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encuesta_opciones');
    }
}
