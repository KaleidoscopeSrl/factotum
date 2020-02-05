<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

use Laravel\Passport\Passport;

use Kaleidoscope\Factotum\Policies\UserPolicy;
use Kaleidoscope\Factotum\Policies\RolePolicy;
use Kaleidoscope\Factotum\Policies\CapabilityPolicy;
use Kaleidoscope\Factotum\Policies\ContentTypePolicy;
use Kaleidoscope\Factotum\Policies\ContentFieldPolicy;
use Kaleidoscope\Factotum\Policies\ContentPolicy;
use Kaleidoscope\Factotum\Policies\MediaPolicy;
use Kaleidoscope\Factotum\Policies\CategoryPolicy;

use Kaleidoscope\Factotum\Observers\ContentTypeObserver;
use Kaleidoscope\Factotum\Observers\ContentFieldObserver;
use Kaleidoscope\Factotum\Observers\ContentObserver;
use Kaleidoscope\Factotum\Observers\CategoryObserver;

use Kaleidoscope\Factotum\Console\Commands\CleanFolders;
use Kaleidoscope\Factotum\Console\Commands\MigrateContentTypeAndFields;
use Kaleidoscope\Factotum\Console\Commands\MigrateMedia;
use Kaleidoscope\Factotum\Console\Commands\MigrateContents;
use Kaleidoscope\Factotum\Console\Commands\ResetAbsUrl;
use Kaleidoscope\Factotum\Console\Commands\DumpAutoload;
use Kaleidoscope\Factotum\Console\Commands\CreateStorageFolders;
use Kaleidoscope\Factotum\Console\Commands\CreateSymbolicLinks;
use Kaleidoscope\Factotum\Console\Commands\FactotumInstallation;



class FactotumServiceProvider extends ServiceProvider
{

	protected $policies = [
		User::class          => UserPolicy::class,
		Role::class          => RolePolicy::class,
		Capability::class    => CapabilityPolicy::class,
		ContentType::class   => ContentTypePolicy::class,
		ContentField::class  => ContentFieldPolicy::class,
		Content::class       => ContentPolicy::class,
		Media::class         => MediaPolicy::class,
		Category::class      => CategoryPolicy::class,
	];


	public function boot(GateContract $gate)
	{
		Schema::defaultStringLength(191);


		// Migrations & Seeds
		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');



		// Configurations
		$this->app['config']->set( 'auth', array_merge(
			$this->app['config']->get('auth', []), require __DIR__ . '/config/auth.php'
		));

		$this->app['config']->set( 'database', array_merge(
			$this->app['config']->get('database', []), require __DIR__ . '/config/database.php'
		));

		$this->app['config']->set( 'mail', array_merge(
			$this->app['config']->get('mail', []), require __DIR__ . '/config/mail.php'
		));

		$this->app['config']->set( 'view', array_merge(
			$this->app['config']->get('view', []), require __DIR__ . '/config/view.php'
		));

		$this->app['config']->set( 'filesystems', array_merge(
			$this->app['config']->get('filesystems', []), require __DIR__ . '/config/filesystems.php'
		));



		// Middlewares
		$this->getRouter()->pushMiddlewareToGroup('session_start', \Illuminate\Session\Middleware\StartSession::class);
		$this->getRouter()->pushMiddlewareToGroup('preflight',     \Kaleidoscope\Factotum\Http\Middleware\PreflightResponse::class);



		// Config, Resources and Public
		$this->publishes([
			// CONFIG
			__DIR__ . '/config/factotum.php'  => config_path('factotum.php'),

			// WEB APP
			__DIR__ . '/public/admin'         => public_path('admin'),

			// MINISITE
			__DIR__ . '/public/assets'        => public_path('assets'),
			__DIR__ . '/resources/views'      => resource_path( 'views' )
		], 'factotum');



		if ($this->app->runningInConsole()) {
			$this->commands([
				CleanFolders::class,
				ResetAbsUrl::class,
				MigrateMedia::class,
				MigrateContentTypeAndFields::class,
				MigrateContents::class,
				DumpAutoload::class,
				CreateStorageFolders::class,
				CreateSymbolicLinks::class,
				FactotumInstallation::class
			]);
		}


		// Models
		ContentType::observe(ContentTypeObserver::class);
		ContentField::observe(ContentFieldObserver::class);
		Content::observe(ContentObserver::class);
		Category::observe(CategoryObserver::class);


		// Routes

		Route::group([
			'prefix'     => 'api/v1',
			'middleware' => [
				'api',
				'session_start',
				'preflight'
			],
			'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Api'
		], function ($router) {
			require __DIR__ . '/routes/api/public/api.php';
			require __DIR__ . '/routes/api/public/auth.php';
		});


		Route::group([
			'prefix'     => 'api/v1',
			'middleware' => [
				'api',
				'auth:api',
				'session_start',
				'preflight',
			],
			'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Api'
		], function ($router) {
			require __DIR__ . '/routes/api/auth.php';
			require __DIR__ . '/routes/api/capability.php';
			require __DIR__ . '/routes/api/category.php';
			require __DIR__ . '/routes/api/content.php';
			require __DIR__ . '/routes/api/content-type.php';
			require __DIR__ . '/routes/api/content-field.php';
			require __DIR__ . '/routes/api/media.php';
			require __DIR__ . '/routes/api/role.php';
			require __DIR__ . '/routes/api/setting.php';
			require __DIR__ . '/routes/api/user.php';
			require __DIR__ . '/routes/api/utility.php';
			require __DIR__ . '/routes/api/tool.php';
		});


		Route::group([
			'middleware' => [
				'web'
			],
			'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers'
		], function ($router) {
			require __DIR__ . '/routes/web.php';
		});


		Passport::routes();
		Passport::enableImplicitGrant();


		// Final pieces and boobs
		$this->_addValidators();


	}


	private function _addValidators()
	{
		Validator::extend('allowed_types', function($attribute, $value, $parameters, $validator) {
			if ( $value == '["*"]' ) {
				return true;
			}

			$value = json_decode( $value, true );

			if ($value && count($value) > 0) {
				$error = false;
				foreach ($value as $format) {
					if (strlen($format) < 3) {
						$error = true;
					}
				}
				return !$error;
			}

			return $value == 'foo';
		});

		Validator::extend('max_mb', function($attribute, $value, $parameters, $validator) {
			if ( $value instanceof UploadedFile && ! $value->isValid() ) {
				return false;
			}

			// If call getSize()/1024/1024 on $value here it'll be numeric and not
			// get divided by 1024 once in the Validator::getSize() method.
			$megabytes = $value->getSize() / 1024 / 1024;

			return $megabytes <= $parameters[0];
		});

		Validator::replacer('max_mb', function($message, $attribute, $rule, $parameters) {
			return str_replace(array(':attribute', ':max'), array($attribute, $parameters[0]), $message);
		});
	}


	public function registerPolicies(GateContract $gate)
	{
		foreach ($this->policies as $key => $value) {
			$gate->policy($key, $value);
		}
	}


	public function register()
	{
	}



	/**
	 * Get the active router.
	 *
	 * @return Router
	 */
	protected function getRouter()
	{
		return $this->app['router'];
	}

}

