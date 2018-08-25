<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


// Factotum - Auth Routes / User Route - Guest
Route::group([  'prefix'     => 'admin',
				'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Admin',
				'middleware' => ['web', 'guest', 'language'] ], function() {

	Route::get('/auth/login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@index']);
	Route::post('/auth/login', 'Auth\LoginController@login');

	Route::get('/user/register', 'User\RegisterController@index');
	Route::post('/user/register', 'User\RegisterController@register');

	Route::get('/auth/password/reset', 'Auth\ForgotPasswordController@index');
	Route::post('/auth/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

	Route::get('/auth/password/reset/{token}', 'Auth\ForgotPasswordController@reset');
	Route::post('/auth/password/reset', 'Auth\ForgotPasswordController@resetUserPassword');

});


Route::group([
	'prefix' => 'admin',
	'namespace' => 'Kaleidoscope\Factotum\Http\Controllers\Admin',
	'middleware' => ['web', 'auth', 'language'] ], function() {

	Route::get('/', 'Controller@index');
	Route::get('/auth/logout', 'Auth\LogoutController@logout');


	// Factotum - User Routes - Logged In
	Route::get('/user/list', 'User\ReadController@index')->middleware('can:view,Kaleidoscope\Factotum\User');
	Route::get('/user/create', 'User\CreateController@create')->middleware('can:create,Kaleidoscope\Factotum\User');
	Route::post('/user/store', 'User\CreateController@store')->middleware('can:create,Kaleidoscope\Factotum\User');
	Route::get('/user/edit/{id}', 'User\UpdateController@edit')->middleware('can:update,Kaleidoscope\Factotum\User,id');
	Route::post('/user/update/{id}', 'User\UpdateController@update')->middleware('can:update,Kaleidoscope\Factotum\User,id');
	Route::get('/user/delete/{id}', 'User\DeleteController@delete')->middleware('can:delete,Kaleidoscope\Factotum\User,id');
	Route::post('/user/delete/{id}', 'User\DeleteController@deleteUser')->middleware('can:delete,Kaleidoscope\Factotum\User,id');


	// Factotum - Role Routes - Logged In
	Route::get('/role/list', 'Role\ReadController@index')->middleware('can:view,Kaleidoscope\Factotum\Role');
	Route::get('/role/create', 'Role\CreateController@create')->middleware('can:create,Kaleidoscope\Factotum\Role');
	Route::post('/role/store', 'Role\CreateController@store')->middleware('can:create,Kaleidoscope\Factotum\Role');
	Route::get('/role/edit/{id}', 'Role\UpdateController@edit')->middleware('can:update,Kaleidoscope\Factotum\Role,id');
	Route::post('/role/update/{id}', 'Role\UpdateController@update')->middleware('can:update,Kaleidoscope\Factotum\Role,id');
	Route::get('/role/delete/{id}', 'Role\DeleteController@delete')->middleware('can:delete,Kaleidoscope\Factotum\Role,id');
	Route::post('/role/delete/{id}', 'Role\DeleteController@deleteRole')->middleware('can:delete,Kaleidoscope\Factotum\Role,id');


	// Factotum - Capability Routes - Logged In
	//Route::get('/capability', function() { return redirect('/admin/capability/list'); });
	Route::get('/capability/list', 'Capability\ReadController@index')->middleware('can:view,Kaleidoscope\Factotum\Capability');
	Route::get('/capability/create', 'Capability\CreateController@create')->middleware('can:create,Kaleidoscope\Factotum\Capability');
	Route::post('/capability/store', 'Capability\CreateController@store')->middleware('can:create,Kaleidoscope\Factotum\Capability');
	Route::get('/capability/edit/{id}', 'Capability\UpdateController@edit')->middleware('can:update,Kaleidoscope\Factotum\Capability');
	Route::post('/capability/update/{id}', 'Capability\UpdateController@update')->middleware('can:update,Kaleidoscope\Factotum\Capability');
	Route::get('/capability/delete/{id}', 'Capability\DeleteController@delete')->middleware('can:delete,Kaleidoscope\Factotum\Capability');

	// Factotum - Content Type Routes - Logged In
	//Route::get('/content-type', function() { return redirect('/admin/content-type/list'); });
	Route::get('/content-type/list', 'ContentType\ReadController@index')->middleware('can:view,Kaleidoscope\Factotum\ContentType');
	Route::get('/content-type/create', 'ContentType\CreateController@create')->middleware('can:create,Kaleidoscope\Factotum\ContentType');
	Route::post('/content-type/store', 'ContentType\CreateController@store')->middleware('can:create,Kaleidoscope\Factotum\ContentType');
	Route::get('/content-type/edit/{id}', 'ContentType\UpdateController@edit')->middleware('can:update,Kaleidoscope\Factotum\ContentType,id');
	Route::post('/content-type/update/{id}', 'ContentType\UpdateController@update')->middleware('can:update,Kaleidoscope\Factotum\ContentType,id');
	Route::get('/content-type/delete/{id}', 'ContentType\DeleteController@delete')->middleware('can:delete,Kaleidoscope\Factotum\ContentType,id');

	// Factotum - Content Fields Routes - Logged In
	//Route::get('/content-field', function() { return redirect('/admin/content-field/list'); });
	Route::get('/content-field/list', 'ContentField\ReadController@index')->middleware('can:view,Kaleidoscope\Factotum\ContentField');
	Route::post('/content-field/sort', 'ContentField\UpdateController@sortFields')->middleware('can:view,Kaleidoscope\Factotum\ContentField');
	Route::get('/content-field/create/{content_type_id}', 'ContentField\CreateController@create')->middleware('can:create,Kaleidoscope\Factotum\ContentField,content_type_id');
	Route::post('/content-field/store/{content_type_id}', 'ContentField\CreateController@store')->middleware('can:create,Kaleidoscope\Factotum\ContentField,content_type_id');
	Route::get('/content-field/edit/{content_type_id}/{id}', 'ContentField\UpdateController@edit')->middleware('can:update,Kaleidoscope\Factotum\ContentField,content_type_id');
	Route::post('/content-field/update/{content_type_id}/{id}', 'ContentField\UpdateController@update')->middleware('can:update,Kaleidoscope\Factotum\ContentField,content_type_id');
	Route::get('/content-field/delete/{id}', 'ContentField\DeleteController@delete')->middleware('can:delete,Kaleidoscope\Factotum\ContentField,id');

	// Factotum - Media Routes - Logged In
	Route::get('/media/list', 'Media\ReadController@index')->middleware('can:view,Kaleidoscope\Factotum\Media,id');
	Route::get('/media/get-images',                 'Media\ReadController@getImages')->middleware('can:view,Kaleidoscope\Factotum\Media,id');
	Route::get('/media/get-media-paginated',        'Media\ReadController@getMediaPaginated')->middleware('can:view,Kaleidoscope\Factotum\Media,id');
	Route::get('/media/delete/{id}',                'Media\DeleteController@delete')->middleware('can:delete,Kaleidoscope\Factotum\Media,id');
	Route::post('/media/delete/{filename}',         'Media\DeleteController@delete')->middleware('can:delete,Kaleidoscope\Factotum\Media,filename');
	Route::get('/media/upload/{content_field_id}',  'Media\UploadController@showUpload')->middleware('can:create,Kaleidoscope\Factotum\Media,id');
	Route::post('/media/upload',                    'Media\UploadController@upload')->middleware('can:create,Kaleidoscope\Factotum\Media,id');
	Route::get('/media/edit/{id}',                  'Media\UpdateController@edit')->middleware('can:update,Kaleidoscope\Factotum\Media,id');
	Route::post('/media/update/{id}',               'Media\UpdateController@update')->middleware('can:update,Kaleidoscope\Factotum\Media,id');

	// Factotum - Categories Routes - Logged In
	//Route::get('/category', function() { return redirect('/admin/category/list'); });
	Route::get('/category/list', 'Category\ReadController@index')->middleware('can:view,Kaleidoscope\Factotum\Category');
	Route::post('/category/get-by-content-type', 'Category\ReadController@getContentTypeCategories')->middleware('can:view,Kaleidoscope\Factotum\Category');
	Route::post('/category/sort', 'Category\UpdateController@sortCategories')->middleware('can:view,Kaleidoscope\Factotum\Category');
	Route::get('/category/create/{content_type_id}', 'Category\CreateController@create')->middleware('can:create,Kaleidoscope\Factotum\Category,content_type_id');
	Route::post('/category/store/{content_type_id}', 'Category\CreateController@store')->middleware('can:create,Kaleidoscope\Factotum\Category,content_type_id');
	Route::get('/category/edit/{id}', 'Category\UpdateController@edit')->middleware('can:update,Kaleidoscope\Factotum\Category,id');
	Route::post('/category/update/{id}', 'Category\UpdateController@update')->middleware('can:update,Kaleidoscope\Factotum\Category,id');
	Route::get('/category/delete/{id}', 'Category\DeleteController@delete')->middleware('can:delete,Kaleidoscope\Factotum\Category,id');

	// Factotum - Settings
	Route::get('/settings', 'Settings\SettingsController@create')->middleware('can:manage-settings,Kaleidoscope\Factotum\Role');
	Route::post('/settings/store', 'Settings\SettingsController@store')->middleware('can:manage-settings,Kaleidoscope\Factotum\Role');
	Route::get('/settings/set-language/{language}', 'Settings\SettingsController@setLanguage')->middleware('can:manage-settings,Kaleidoscope\Factotum\Role');

	// Factotum - Tools
	Route::get('/tools', 'Tools\ReadController@index');
	Route::get('/tools/resize-media', 'Tools\ResizeMediaController@index')->middleware('can:create,Kaleidoscope\Factotum\Media,id');
	Route::get('/tools/do-resize-media', 'Tools\ResizeMediaController@resize')->middleware('can:create,Kaleidoscope\Factotum\Media,id');
	Route::post('/tools/do-resize-media', 'Tools\ResizeMediaController@resize')->middleware('can:create,Kaleidoscope\Factotum\Media,id');
	Route::post('/tools/make-resize-media', 'Tools\ResizeMediaController@resizeMedia')->middleware('can:create,Kaleidoscope\Factotum\Media,id');

	// Factotum - Content Routes - Logged In
	Route::get('/content/list/{content_type_id}', 'Content\ReadController@indexList')->middleware('can:view,Kaleidoscope\Factotum\Content,content_type_id');
	Route::post('/content/sort/{content_type_id}', 'Content\UpdateController@sortContents')->middleware('can:view,Kaleidoscope\Factotum\ContentField');
	Route::get('/content/create/{content_type_id}', 'Content\CreateController@create')->middleware('can:create,Kaleidoscope\Factotum\Content,content_type_id');
	Route::post('/content/store/{content_type_id}', 'Content\CreateController@store')->middleware('can:create,Kaleidoscope\Factotum\Content,content_type_id');
	Route::get('/content/edit/{id}', 'Content\UpdateController@edit')->middleware('can:update,Kaleidoscope\Factotum\Content,id');
	Route::post('/content/update/{id}', 'Content\UpdateController@update')->middleware('can:update,Kaleidoscope\Factotum\Content,id');
	Route::get('/content/delete/{id}', 'Content\DeleteController@delete')->middleware('can:delete,Kaleidoscope\Factotum\Content,id');

});


Route::group(['middleware' => ['web', 'language']], function () {
	Route::get('/{uri?}', 'Kaleidoscope\Factotum\Http\Controllers\FrontController@index')->where('uri', '.*');
	Route::post('/{uri?}', 'Kaleidoscope\Factotum\Http\Controllers\FrontController@index')->where('uri', '.*');
});

