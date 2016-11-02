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

Route::get('/comics','HomeController@comics')->name('marvel-comics');
Route::get('/comic/{id}','HomeController@comic')->name('marvel-comic');
Route::get('/characters','HomeController@characters')->name('marvel-characters');
Route::get('/creators','HomeController@creators')->name('marvel-creators');
Route::get('/events','HomeController@events')->name('marvel-events');
Route::get('/series','HomeController@series')->name('marvel-series');
Route::get('/stories','HomeController@stories')->name('marvel-stories');



Route::get('/api/comics','MarvelService@comics')->name('marvel-api-comics');
Route::get('/api/characters','MarvelService@characters')->name('marvel-api-acharacters');
Route::get('/api//creators','MarvelService@creators')->name('marvel-api-creators');
Route::get('/api//events','MarvelService@events')->name('marvel-api-events');
Route::get('/api//series','MarvelService@series')->name('marvel-api-series');
Route::get('/api//stories','MarvelService@stories')->name('marvel-api-stories');
