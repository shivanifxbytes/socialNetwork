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
// user
Route::group(['middleware' => ['web']], function () {
	Route::get('/', 'Auth\LoginController@getLogin');
	Route::post('/', 'Auth\LoginController@postLogin');
	Route::get('/welcome', ['as'=>'welcome','uses'=>'HomeController@index']);
	Route::get('/friendlist', ['as'=>'friendlist','uses'=>'HomeController@viewFriendlist']);
	Route::post('/welcome','HomeController@uploadImage');
	Route::get('add/{id}',['as'=>'add','uses'=>'HomeController@addFriend']);
	Route::get('accept/{id}',['as'=>'accept','uses'=>'HomeController@acceptFriendships']);
	Route::get('delete/{id}',['as'=>'accept','uses'=>'HomeController@deniedFriendship']);
	Route::get('/friendRequest', ['as'=>'friendRequest','uses'=>'HomeController@viewFriendRequest']);
	Route::get('/findFriend', ['as'=>'findFriend','uses'=>'HomeController@viewAllFriendlist']);
	Route::get('/logout', 'HomeController@getLogout');
	Route::get('/register', 'Auth\RegisterController@register');
	Route::post('/register', ['as'=>'register','uses'=>'Auth\RegisterController@userRegister']);
	Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

});
// admin
Route::group(['middleware' => ['web']], function () {
	Route::get('/admin', 'AdminController@getLogin');
	Route::post('/admin', 'AdminController@postLogin');
	Route::get('/dashboard', ['as'=>'dashboard','uses'=>'DashboardController@index']);
});

Route::get('/home', 'HomeController@index')->name('home');

