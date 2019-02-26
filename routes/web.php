<?php

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index')->name('home');
Route::DELETE('/eliminar-producto{id}', 'HomeController@destroyProduct')->name('destroyProduct');
