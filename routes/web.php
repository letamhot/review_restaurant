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
