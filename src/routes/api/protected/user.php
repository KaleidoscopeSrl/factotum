<?php

use Illuminate\Support\Facades\Route;

Route::group([
	'prefix'     => 'user',
], function () {


	Route::post('/create',        'UserController@create')->middleware('can:create,Kaleidoscope\Factotum\User');

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\User'], function() {
		Route::get('/collected',      'UserController@collected');
		Route::get('/paginated',      'UserController@paginated');
		Route::get('/single/{id}',    'UserController@single');
	});

	Route::put('/update/{id}',    'UserController@update')->middleware('can:update,Kaleidoscope\Factotum\User,id');

	Route::delete('/delete/{id}',   'UserController@delete')->middleware('can:delete,Kaleidoscope\Factotum\User,id');
	Route::delete('/delete-users',  'UserController@deleteUsers')->middleware('can:deleteMultipleUsers,Kaleidoscope\Factotum\User');


});

