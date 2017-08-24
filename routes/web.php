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

/**
 * Convert some text to Markdown...
 */
function markdown($text) {
    return (new ParsedownExtra)->text($text);
}

// Home page.
Route::get('/', function () {
    return redirect('feed');
//    return view('welcome');
});

// Auth routes.
Auth::routes();

// Pages
Route::get('home', 'HomeController@index');
Route::get('feed', 'HomeController@showFeed');

// Confirm
Route::get('confirm/{token}/{email}', 'HomeController@confirmUser');

Route::get('language/{language}', 'GeneralController@switchLanguage')->name('language');

// Post related
Route::get('post/{post}', function (\App\Post $post) {
    return Auth::check() ? view('post-authed', compact('post')) : view('post-unauthed', compact('post'));
})->name('post');
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
Route::put('@{userName}', 'UserController@followUser')->name('follow');
Route::get('settings', 'UserController@showSettings')->name('settings');
Route::post('settings/personal', 'UserController@savePersonalSettings')->name('settings.personal');
Route::post('settings/privacy', 'UserController@savePrivacySettings')->name('settings.privacy');
Route::post('settings/feed', 'UserController@saveFeedSettings')->name('settings.feed');
Route::post('upload-avatar', 'UserController@uploadAvatar')->name('upload-avatar');
Route::post('get-inbox', 'UserController@getInbox')->name('get-inbox');
Route::post('check-in', 'UserController@checkIn')->name('checkin');

// Notification
Route::patch('read/notification', 'UserController@readNotifications');

// Search
Route::get('search', 'UserController@showSearch');

// Voyager routes
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('voyager.login');
    Route::post('login', 'Auth\LoginController@login');
});

// Dynamic show page.
Route::get('{page}', 'PageController@showPage');
