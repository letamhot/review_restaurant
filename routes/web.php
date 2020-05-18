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
    return view('welcome');
});


Route::get('/index', function () {
    return view('webindex');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('tag', 'TagController');
// tag deleted
Route::get('/tagdel', 'TagController@showdeletedtags')->name('tagdel');
Route::get('/tagdel/restore/{id}', 'TagController@restoreDeletedTags')->name('restoreTag');

Route::get('/tagdel/{id}', 'TagController@forceDelete')->name('tagdel.forceDelete');
