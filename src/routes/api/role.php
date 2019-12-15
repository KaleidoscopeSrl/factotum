<?php

/**
 *
 *   ROLES
 *
 */

Route::group([
	'prefix'     => 'role',
	'middleware' => 'auth:api',
	'namespace'  => 'Role'
], function () {

	Route::post('/create',             'CreateController@create');
	Route::get('/list',                'ReadController@getList');
	Route::get('/detail/{id}',         'ReadController@getDetail');
	Route::put('/update/{id}',         'UpdateController@update');
	Route::delete('/delete/{id}',      'DeleteController@remove');

});