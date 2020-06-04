<?php
/**
 * Created by PhpStorm.
 * User: filippo
 * Date: 03/06/2020
 * Time: 11:38
 */

Route::get('/admin/{uri?}', function () { return redirect('/admin/' ); })->where('uri', '.*');

// TODO: spostare da api a web
// Route::get('/sitemap', 'Api\Tools\SitemapController@generate');


Route::get('/{uri?}',  'FrontController@index')->where('uri', '.*');
Route::post('/{uri?}', 'FrontController@index')->where('uri', '.*');