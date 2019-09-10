<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



/**
 * ========================================
 *
 *   AUTH PUBLIC ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'    => 'auth',
	'namespace' => 'Auth'
], function() {

	Route::post('/login',                'LoginController@login');
	Route::post('/forgotten-password',   'ForgotPasswordController@forgottenPassword');

	Route::get('/mailable', function () {
		return new Kaleidoscope\Factotum\Mail\AuthForgottenPassword( new Kaleidoscope\Factotum\User, 'test' );
	});

});


/**
 * ========================================
 *
 *   PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'     => 'auth',
	'namespace'  => 'Auth',
	'middleware' => 'auth:api'
], function() {

	Route::post('/logout',             'LogoutController@logout');

});






