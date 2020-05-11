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


// Category testing
Route::resource('/category', 'CategoryController');
Route::get('categories', 'CategoryController@ajaxIndex')->name('category.ajaxIndex');
Route::post('categories', 'CategoryController@ajaxStore')->name('category.ajaxStore');

Route::get('categories/{category}/edit', 'CategoryController@ajaxEdit')->name('category.ajaxEdit');
Route::put('categories/{category}', 'CategoryController@ajaxUpdate')->name('category.ajaxUpdate');

Route::delete('categories/{category}', 'CategoryController@ajaxDelete')->name('category.ajaxDelete');
Route::delete('categories/{category}/hardDelete', 'CategoryController@ajaxHardDelete')->name('category.ajaxHardDelete');
Route::patch('categories/{category}/restoreDelete', 'CategoryController@ajaxRestoreDelete')->name('category.ajaxRestoreDelete');
Route::get('categories/trash', 'CategoryController@getTrashRecords')->name('category.getTrashRecords');
=======

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

