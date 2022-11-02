<?php

use Illuminate\Support\Facades\Route;

Route::get('cliente/', 'cliente\ClienteController@index');
Route::post('cliente/', 'cliente\ClienteController@create');
Route::get('cliente/{id}', 'cliente\ClienteController@show');
Route::put('cliente/{id}', 'cliente\ClienteController@update');
Route::delete('cliente/{id}', 'cliente\ClienteController@destroy');
Route::get('cliente/final-placa/{numero}', 'cliente\ClienteController@getPlaca');

