<?php


Route::get('/admin/{uri?}', function () { return redirect('/admin/' ); })->where('uri', '.*');

// TODO: spostare da api a web
Route::get('/sitemap', 'Api\Tools\SitemapController@generate');


Route::get('/{uri?}',  '\Kaleidoscope\Factotum\Http\Controllers\Web\FrontController@index')->where('uri', '.*');
Route::post('/{uri?}', '\Kaleidoscope\Factotum\Http\Controllers\Web\FrontController@index')->where('uri', '.*');