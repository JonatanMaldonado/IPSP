<?php

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'EncuestaController@index')->name('home');
Route::post('/encuesta/fn/crear', 'EncuestaController@create')->name('encuesta.fn.crear');
//Route::get('/home', 'HomeController@index')->name('home');