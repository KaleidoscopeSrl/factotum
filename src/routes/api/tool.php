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

	Route::post('/resize-media',         'ResizeMediaController@resizeMedia');
	Route::post('/save-sitemap',         'SitemapController@savePreference');

});