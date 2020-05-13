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



// ADMIN - Category CRUD
Route::resource('/category', 'CategoryController');
Route::delete('/category/{category}/emptyTrash', 'CategoryController@emptyTrash')->name('category.emptyTrash');
Route::patch('/category/{category}/restoreTrash', 'CategoryController@restoreTrash')->name('category.restoreTrash');
Route::get('/category/trash/sd', 'CategoryController@getTrashRecords')->name('category.trash');
Auth::routes();


Route::resource('tag', 'TagController');
// tag deleted
Route::get('/tagdel', 'TagController@showdeletedtags')->name('tagdel');
Route::get('/tagdel/restore/{id}', 'TagController@restoreDeletedTags')->name('restoreTag');




Route::resource('api/post', 'PostController');

Route::get('/post', function () {
    return view('post.index');
});
Route::post('/post/add', 'PostController@store')->name('post.store');

Route::post('post/delete/{id}', 'PostController@destroy');
Route::get('post/get/{id}', 'PostController@edit');
Route::post('post/update/{id}', 'PostController@update');


