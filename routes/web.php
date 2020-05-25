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

// DISABLE REGISTER

Auth::routes([
    'register' => false,
    'reset' => false]);

Route::get('/', function () {
    return view('front-end.landing-page');
});

Route::get('/page-detail', function () {
    return view('front-end.page_detail');
});
Route::get('/api/category', 'CategoryController@Api_category')->name('api.category');

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

// ADMIN - Tag CRUD
Route::resource('/tag', 'TagController');
Route::delete('/tag/{tag}/emptyTrash', 'TagController@emptyTrash')->name('tag.emptyTrash');
Route::patch('/tag/{tag}/restoreTrash', 'TagController@restoreTrash')->name('tag.restoreTrash');
Route::get('/tag/trash/sd', 'TagController@getTrashRecords')->name('tag.trash');

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
    Route::get('/post/all-category', 'PostController@getAllCategory')->name('post.getAllCategory');

    Route::get('/post/all-tag', 'PostController@getAllTag')->name('post.getAllTag');

});
Route::group(['middleware' => ['auth']], function () {

    Route::resource('/role', 'RoleController');
    Route::delete('/roles/{role}/emptyTrash', 'RoleController@emptyTrash')->name('role.emptyTrash');
    Route::patch('/roles/{role}/restoreTrash', 'RoleController@restoreTrash')->name('role.restoreTrash');
    Route::get('/roles/trash/sd', 'RoleController@getTrashRecords')->name('role.trash');

});

Route::get('/show/{id}', 'ArticleController@show');

Route::get('/listAll', 'ArticleController@index');
