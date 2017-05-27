<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

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
    	// Publish Configurations
		$this->publishes([
			__DIR__ . '/config/auth.php'     => config_path('factotum/auth.php'),
			__DIR__ . '/config/factotum.php' => config_path('factotum/factotum.php'),
			__DIR__ . '/config/view.php'     => config_path('factotum/view.php'),
		], 'config');
		$this->app['config']['auth'] = Config::get('factotum.auth');


		// Migrations & Seeds
		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');


		// Routes
		$this->loadRoutesFrom(__DIR__ . '/routes/web.php');


		// Translations
		$this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'factotum');


		// Middlewares
		app('router')->aliasMiddleware('language', 'Kaleidoscope\Factotum\Http\Middleware\Language');


		// View
		$this->loadViewsFrom(__DIR__ . '/resources/views', 'factotum');


		// Policies
		$this->registerPolicies($gate);

		// Resources and Public
		$this->publishes([
			__DIR__ . '/resources/assets'         => resource_path('assets'),
			__DIR__ . '/public/assets'            => public_path('assets'),
			__DIR__ . '/resources/views/frontend' => resource_path( 'views/frontend' )
		], 'public');


		if ($this->app->runningInConsole()) {
			$this->commands([
				CreateStorageFolders::class,
				CreateSymbolicLinks::class,
				FactotumInstallation::class
			]);
		}

		Validator::extend('allowed_types', function($attribute, $value, $parameters, $validator) {
			if ($value == '*') {
				return true;
			}
			$formats = explode(',', $value);
			if (count($formats) > 0) {
				$error = false;
				foreach ($formats as $format) {
					if (strlen($format) < 3) {
						$error = true;
					}
				}
				return !$error;
			}
			return $value == 'foo';
		});

		if ( env('FACTOTUM_INSTALLED') ) {
			$contentTypes = ContentType::all();
			View::share('contentTypes', $contentTypes);
		}

		ContentType::observe(ContentTypeObserver::class);
		ContentField::observe(ContentFieldObserver::class);
		Content::observe(ContentObserver::class);
		Category::observe(CategoryObserver::class);

    }

	public function registerPolicies(GateContract $gate)
	{
		foreach ($this->policies as $key => $value) {
			$gate->policy($key, $value);
		}
	}


    public function register()
    {
        //
    }
}
