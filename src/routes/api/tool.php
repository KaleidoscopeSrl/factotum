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

	Route::post('/get-resize',                 'ResizeMediaController@getResize');
	Route::post('/do-resize',                  'ResizeMediaController@doResize');
	Route::post('/resize-media/{mediaId}',     'ResizeMediaController@resizeMedia');

	Route::post('/save-sitemap',               'SitemapController@savePreference');

});