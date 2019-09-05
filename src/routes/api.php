<?php


Route::group([
	'prefix'     => 'api/v1',
	'middleware' => [ 'api', 'preflight', 'start_session' ],
	'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Api'
], function () {


	/**
	 *
	 *   MEDIA
	 *
	 */
	Route::group(['prefix' => 'media', 'namespace' => 'Media' ], function () {
		Route::post('/upload',              'UploadController@upload');
		Route::post('/list',                'ReadController@getList');
		Route::post('/detail/{id}',         'ReadController@getDetail');
		Route::post('/update-status/{id}',  'UpdateController@updateStatus');
		Route::delete('/delete/{id}',       'DeleteController@remove');
	});


	/**
	 *
	 *   RUOLI
	 *
	 */
	Route::group(['prefix' => 'role', 'namespace' => 'Role'], function () {
		Route::post('/create',              'CreateController@create');
		Route::post('/list',                 'ReadController@getList');
		Route::post('/detail/{id}',         'ReadController@getDetail');
		Route::post('/update/{id}',         'UpdateController@update');
		Route::post('/delete/{id}',         'DeleteController@remove');
	});


	/**
	 *
	 *   USERS
	 *
	 */
	Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
		Route::post('/create',              'CreateController@create');
		Route::post('/list',                'ReadController@getList');
		Route::post('/detail/{id}',         'ReadController@getDetail');
		Route::post('/update/{id}',         'UpdateController@update');
		Route::post('/delete/{id}',         'DeleteController@remove');
	});


	/**
	 *
	 *   CONTENT TYPE
	 *
	 */
	Route::group(['prefix' => 'content-type', 'namespace' => 'ContentType'], function () {
		Route::post('/create',              'CreateController@create');
		Route::post('/list',                'ReadController@getList');
		Route::post('/detail/{id}',         'ReadController@getDetail');
		Route::post('/update/{id}',         'UpdateController@update');
		Route::delete('/delete/{id}',       'DeleteController@remove');
	});


	/**
	 *
	 *   CATEGORY
	 *
	 */
	Route::group(['prefix' => 'category', 'namespace' => 'Category'], function () {
		Route::post('/create',              'CreateController@create');
		Route::post('/list',                'ReadController@getList');
		Route::post('/detail/{id}',         'ReadController@getDetail');
		Route::post('/update/{id}',         'UpdateController@update');
		Route::delete('/delete/{id}',       'DeleteController@remove');
	});


	/**
	 *
	 *   CONTENT FIELD
	 *
	 */
	Route::group(['prefix' => 'content-field', 'namespace' => 'ContentField'], function () {
		Route::post('/create',              'CreateController@create');
		Route::post('/list',                'ReadController@getList');
		Route::post('/detail/{id}',         'ReadController@getDetail');
		Route::post('/update/{id}',         'UpdateController@update');
		Route::delete('/delete/{id}',       'DeleteController@remove');
	});


});
