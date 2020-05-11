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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('api/post', 'PostController');

Route::get('/post', function () {
    return view('post.index');
});
Route::post('/post/add', 'PostController@store')->name('post.store');

Route::post('post/delete/{id}', 'PostController@destroy');
Route::get('post/get/{id}', 'PostController@edit');
Route::post('post/update/{id}', 'PostController@update');

// Route::put('/post/{postId}', 'PostController@update')->name('post.update');
// Route::get('/post/delete/{postId}', 'PostController@destroy')->name('post.destroy');
