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

Route::get('/home', 'HomeController@index');
Route::get('/feed', 'HomeController@showFeed');
Route::get('/confirm/{token}/{email}', 'HomeController@confirmUser');
Route::post('/upload', 'HomeController@uploadImages')->name('upload');

Route::get('language/{language}', 'GeneralController@switchLanguage');

// Post related
Route::post('/post', 'HomeController@postNew')->name('post-new');
Route::put('like-post/{post}', 'HomeController@likePost')->name('like-post');

// Locked
Route::get('locked', 'HomeController@showLocked')->name('locked');
Route::post('locked', 'HomeController@unlock');
Route::put('locked', 'HomeController@resendCode');

// Voyager routes
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('voyager.login');
    Route::post('login', 'Auth\LoginController@login');
});
