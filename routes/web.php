<?php

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'EncuestaController@index')->name('home');
Route::get('/encuesta/{id}', 'EncuestaController@show')->name('encuesta.show');

//Ajax de encuestas
Route::post('/encuesta/fn/crear_encuesta', 'EncuestaController@crearEncuesta')->name('encuesta.fn.crear');
Route::post('/opcion/fn/crear_opcion', 'EncuestaController@crearOpcion')->name('opcion.fn.crear');


//Route::get('/home', 'HomeController@index')->name('home');