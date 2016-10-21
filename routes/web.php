<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/comics','MarvelController@comics')->name('marvel-comics');
Route::get('/comic/{id}','MarvelController@comic')->name('marvel-comic');

Route::get('/characters','MarvelController@characters')->name('marvel-characters');

Route::get('/creators','MarvelController@creators')->name('marvel-creators');

Route::get('/events','MarvelController@events')->name('marvel-events');

Route::get('/series','MarvelController@series')->name('marvel-series');

Route::get('/stories','MarvelController@stories')->name('marvel-stories');
