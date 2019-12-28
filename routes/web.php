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
    return redirect()->route('login');
});


Auth::routes();


Route::group([
	'middleware' => 'auth'
], function(){
	Route::get('dashboard','IndexController@dashboard')->name('dashboard');
	Route::resource('post', 'PostController');
	Route::resource('comment', 'CommentController');
	Route::resource('users', 'UsersController');
	Route::resource('friends', 'FriendsController');
	Route::resource('like', 'LikeController');
	Route::resource('dislike', 'DislikeController');
	Route::get('profile', 'IndexController@profile')->name('profile');
	Route::post('profile/changePassword','IndexController@changePassword')->name('ChangePassword');
	Route::post('profile/changeProfile','IndexController@changeProfile')->name('changeProfile');
	Route::post('users/searchbyname', 'UsersController@searchByName')->name('searchByName');
	Route::get('friends', 'FriendsController@index')->name('friends');


});

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');


