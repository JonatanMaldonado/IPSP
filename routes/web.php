<?php

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/encuestas', 'EncuestaController@index')->name('encuestas');

//Route::get('/home', 'HomeController@index')->name('home');