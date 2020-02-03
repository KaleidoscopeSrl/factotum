<?php

/**
 *
 *   MEDIA
 *
 */
Route::group([
	'prefix'    => 'media',
	'namespace' => 'Media'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\Media'], function() {
		Route::post('/upload',                 'UploadController@upload');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Media'], function() {
		Route::post('/list',                   'ReadController@getList');
		Route::post('/detail/{id}',            'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\Media'], function() {
		Route::post('/update/{id}',            'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Media'], function() {
		Route::delete('/delete/{id}',          'DeleteController@remove');
	});

});