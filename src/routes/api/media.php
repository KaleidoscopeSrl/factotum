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
	Route::post('/update-status/{id}',     'UpdateController@updateStatus');
	Route::delete('/delete/{id}',          'DeleteController@remove');

});