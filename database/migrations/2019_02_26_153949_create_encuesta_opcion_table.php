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
        Schema::create('encuesta_opcion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_encuesta')->unsigned();
            $table->integer('id_opcion')->unsigned();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->foreign('id_encuesta')->references('id')->on('encuestas');
            $table->foreign('id_opcion')->references('id')->on('opciones');
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
        Schema::dropIfExists('encuesta_opcion');
    }
}
