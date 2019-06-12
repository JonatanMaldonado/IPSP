<?php

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'EncuestaController@index')->name('home');
Route::get('/encuesta/{id}', 'EncuestaController@show')->name('encuesta.show');
Route::get('/encuesta/editar/{id}', 'EncuestaController@showEdit')->name('encuesta.showEdit');

//Peticiones Ajax Encuestas
Route::post('/encuesta/fn/crear_encuesta', 'EncuestaController@crearEncuesta')->name('encuesta.fn.crear');
Route::put('/encuesta/fn/editar_encuesta', 'EncuestaController@editarEncuesta')->name('encuesta.fn.editar');
Route::post('/opcion/fn/crear_opcion', 'EncuestaController@crearOpcion')->name('opcion.fn.crear');
Route::put('/encuesta/fn/voto_user', 'EncuestaController@votoUser')->name('encuesta.fn.voto_user');
Route::put('/opcion/fn/editar_opcion', 'EncuestaController@editarOpcion')->name('opcion.fn.editar');
Route::put('/opcion/fn/eliminar_opcion', 'EncuestaController@eliminarOpcion')->name('opcion.fn.eliminar');


Route::get('/perfil/{id}', 'PerfilController@show')->name('perfil.show');

//Route::get('/home', 'HomeController@index')->name('home');