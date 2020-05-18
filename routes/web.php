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

// DISABLE REGISTER
Auth::routes([
    'register' => false,
    'reset' => false, ]);

// OAuth login
Route::get('oauth/redirect/{driver}', 'SocialAuthController@redirect')->name('social.redirect');
Route::get('oauth/callback/{driver}', 'SocialAuthController@callback')->name('social.callback');

// ADMIN - Category CRUD
Route::resource('/category', 'CategoryController');
Route::delete('/category/{category}/emptyTrash', 'CategoryController@emptyTrash')->name('category.emptyTrash');
Route::patch('/category/{category}/restoreTrash', 'CategoryController@restoreTrash')->name('category.restoreTrash');
Route::get('/category/trash/sd', 'CategoryController@getTrashRecords')->name('category.trash');

// ADMIN - User CRUD
Route::resource('/user', 'UserController');

Route::resource('tag', 'TagController');
// tag deleted
Route::get('/tagdel', 'TagController@showdeletedtags')->name('tagdel');
Route::get('/tagdel/restore/{id}', 'TagController@restoreDeletedTags')->name('restoreTag');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('api/post', 'PostController');

    Route::get('/post', function () {
        return view('backend.post.index');
    });
    Route::post('/post/add', 'PostController@store')->name('post.store');
    Route::get('/post/show/{id}', 'PostController@show')->name('post.show');

    Route::post('post/delete/{id}', 'PostController@destroy');
    Route::get('post/get/{id}', 'PostController@edit');
    Route::post('post/update/{id}', 'PostController@update');
    Route::delete('/post/{post}/emptyTrash', 'PostController@emptyTrash')->name('post.emptyTrash');
    Route::patch('/post/{post}/restoreTrash', 'PostController@restoreTrash')->name('post.restoreTrash');
    Route::get('/post/trash/sd', 'PostController@getTrashRecords')->name('post.trash');

});
Route::group(['middleware' => ['auth']], function () {

Route::resource('/role', 'RoleController');
Route::delete('/roles/{role}/emptyTrash', 'RoleController@emptyTrash')->name('role.emptyTrash');
Route::patch('/roles/{role}/restoreTrash', 'RoleController@restoreTrash')->name('role.restoreTrash');
Route::get('/roles/trash/sd', 'RoleController@getTrashRecords')->name('role.trash');

});
