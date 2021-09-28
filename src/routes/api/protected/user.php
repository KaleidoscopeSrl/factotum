<?php

use Illuminate\Support\Facades\Route;

Route::group([
	'prefix'     => 'user',
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\User'], function() {
		Route::post('/create',        'UserController@create');
	});


	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\User'], function() {
		Route::get('/collected',      'UserController@collected');
		Route::get('/paginated',      'UserController@paginated');
		Route::get('/single/{id}',    'UserController@single');
	});


	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\User,id'], function() {
		Route::put('/update/{id}',    'UserController@update');
	});


	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\User,id'], function() {
		Route::delete('/delete/{id}',      'UserController@delete');
	});


	// TODO: sistemare
	Route::group(['middleware' => 'can:deleteMultiple,Kaleidoscope\Factotum\User'], function() {
		Route::delete('/delete-users',     'UserController@deleteUsers');
	});


});

