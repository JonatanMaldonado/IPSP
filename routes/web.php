<?php

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'EncuestaController@index')->name('home');

//Route::get('/home', 'HomeController@index')->name('home');