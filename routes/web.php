<?php

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'EncuestaController@index')->name('home');
Route::get('/votacion/{id}', 'EncuestaController@show')->name('encuesta.show');
Route::get('/votacion/editar/{id}', 'EncuestaController@showEdit')->name('encuesta.showEdit');
Route::get('/resultados', 'ResultadoController@index')->name('resultado.index');
Route::get('/votacion/{id}/resultados', 'ResultadoController@show')->name('resultado.show');

//Peticiones Ajax Encuestas
Route::post('/votacion/fn/crear_encuesta', 'EncuestaController@crearEncuesta')->name('encuesta.fn.crear');
Route::put('/votacion/fn/editar_encuesta', 'EncuestaController@editarEncuesta')->name('encuesta.fn.editar');
Route::post('/opcion/fn/crear_opcion', 'EncuestaController@crearOpcion')->name('opcion.fn.crear');
Route::put('/votacion/fn/voto_user', 'EncuestaController@votoUser')->name('encuesta.fn.voto_user');
Route::put('/opcion/fn/editar_opcion', 'EncuestaController@editarOpcion')->name('opcion.fn.editar');
Route::put('/opcion/fn/eliminar_opcion', 'EncuestaController@eliminarOpcion')->name('opcion.fn.eliminar');

Route::get('/perfil', 'PerfilController@show')->name('perfil.show');
Route::get('/perfil/edit', 'PerfilController@edit')->name('perfil.edit');
Route::post('/perfil/fn/editar_perfil', 'PerfilController@update')->name('perfil.update');

//Route::get('/home', 'HomeController@index')->name('home');