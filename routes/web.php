<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('start');
});

Route::get('game/{id}', 'GameController@show');
Route::post('game', 'GameController@create');
Route::post('game/{id}/hit', 'GameController@hit');
Route::post('game/{id}/stand', 'GameController@stand');

Route::get('dev/card-deck', function () {
    return view('dev.card-deck');
});
