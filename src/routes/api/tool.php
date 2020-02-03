<?php

/**
 *
 *   MEDIA
 *
 */
Route::group([
	'prefix'    => 'tool',
	'namespace' => 'Tools'
], function () {

	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\Media'], function() {
		Route::post('/get-resize',                 'ResizeMediaController@getResize');
		Route::post('/do-resize',                  'ResizeMediaController@doResize');
		Route::post('/resize-media/{mediaId}',     'ResizeMediaController@resizeMedia');
	});

	Route::group(['middleware' => 'can:manage-settings,Kaleidoscope\Factotum\Role'], function() {
		Route::post('/save-sitemap',               'SitemapController@savePreference');
	});

});