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
    return redirect('feed');
//    return view('welcome');
});

Auth::routes();

// Pages
Route::get('home', 'HomeController@index');
Route::get('feed', 'HomeController@showFeed');

// Confirm
Route::get('confirm/{token}/{email}', 'HomeController@confirmUser');

Route::get('language/{language}', 'GeneralController@switchLanguage')->name('language');

// Post related
Route::post('posts/{page}', 'HomeController@loadMorePosts');
Route::post('post', 'HomeController@postNew')->name('post-new');
Route::post('upload', 'HomeController@uploadImages')->name('upload');
Route::put('like-post/{post}', 'HomeController@likePost')->name('like-post');
Route::delete('post/{post}', 'HomeController@deletePost');

// Comment related
Route::post('comment/{post}', 'HomeController@commentPost');
Route::put('like-comment/{comment}', 'HomeController@likeComment');
Route::get('load-comments/{post}', 'HomeController@loadComments');
//Route::delete('comment/{comment}', 'HomeController@loadComments');

// Locked
Route::get('locked', 'HomeController@showLocked')->name('locked');
Route::post('locked', 'HomeController@unlock');
Route::put('locked', 'HomeController@resendCode');

// User
Route::get('@{userName}', 'UserController@showProfile')->name('profile');
Route::post('upload-avatar', 'UserController@uploadAvatar')->name('upload-avatar');

// Voyager routes
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('voyager.login');
    Route::post('login', 'Auth\LoginController@login');
});
