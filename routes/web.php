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

use App\Notifications\InvoicePaid;
use App\User;

Auth::routes([
    'register' => false,
    'reset' => false
    ]);

Route::get('/', function () {
    // $user = Auth::user();
    // $when = now()->addMinutes(10);
    // Notification::send($user, new InvoicePaid)->delay($when);  
    // $user->notify(new InvoicePaid(User::findOrFail(2)));
    return view('front-end.landingpage');
});

Route::get('/page-detail', function () {
    return view('front-end.page_detail');
});


// OAuth login
Route::get('oauth/redirect/{driver}', 'SocialAuthController@redirect')->name('social.redirect');
Route::get('oauth/callback/{driver}', 'SocialAuthController@callback')->name('social.callback');

Route::group(['middleware' => ['auth','can:isAdmin']], function () {
    
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
  
    // ADMIN - Role CRUD
    Route::resource('/role', 'RoleController');
    Route::delete('/roles/{role}/emptyTrash', 'RoleController@emptyTrash')->name('role.emptyTrash');
    Route::patch('/roles/{role}/restoreTrash', 'RoleController@restoreTrash')->name('role.restoreTrash');
    Route::get('/roles/trash/sd', 'RoleController@getTrashRecords')->name('role.trash');
  
    // ADMIN - Post CRUD
    Route::get('/post', function () {
        return view('backend.post.index');
    });
    Route::resource('api/post', 'PostController');

    Route::get('/post/check-status', 'PostController@checkstatus')->name('post.checkstatus');
    Route::get('/post/status', 'PostController@status')->name('post.status');
    Route::post('/post/check/{id}', 'PostController@check')->name('post.check');


});
Route::group(['middleware' => ['auth','can:isAdmin'||'can:isUser']], function () {
   
    Route::post('/post/add', 'PostController@store')->name('post.store');
    Route::get('/post/show/{id}', 'PostController@show')->name('post.show');
    Route::get('post/get/{id}', 'PostController@edit');
    Route::post('post/update/{id}', 'PostController@update');
    Route::get('/post/all-category', 'PostController@getAllCategory')->name('post.getAllCategory');
    Route::get('/post/all-tag', 'PostController@getAllTag')->name('post.getAllTag');
    Route::get('/post/user-post', 'PostController@user_post')->name('post.user-post');
    Route::post('post/delete/{id}', 'PostController@destroy');
    Route::delete('/post/{post}/emptyTrash', 'PostController@emptyTrash')->name('post.emptyTrash');
    Route::patch('/post/{post}/restoreTrash', 'PostController@restoreTrash')->name('post.restoreTrash');
    Route::get('/post/trash/sd', 'PostController@getTrashRecords')->name('post.trash');
    Route::get('/post/postuser', 'PostController@postuser')->name('post.postuser');

});

Route::get('/api/category', 'CategoryController@Api_category')->name('api.category');
Route::get('/post/showTag', 'PostController@showTag')->name('post.showTag');

Route::resource('/article', 'ArticleController');
Route::get('/show/{id}', 'ArticleController@show');

Route::get('/listAll', 'ArticleController@index');



