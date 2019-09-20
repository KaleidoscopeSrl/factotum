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

	Route::post('/upload',                 'UploadController@upload');
	Route::post('/list',                   'ReadController@getList');
	Route::post('/detail/{id}',            'ReadController@getDetail');
	Route::post('/update/{id}',            'UpdateController@update');
	Route::delete('/delete/{id}',          'DeleteController@remove');

});