<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class FactotumRoutingServiceProvider extends ServiceProvider
{
	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'Kaleidoscope\Factotum\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot()
	{
		parent::boot();
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map()
	{
		$this->mapApiRoutes();
	}

	protected function mapApiRoutes()
	{
		Route::group([
			'prefix' => 'api',
			'middleware' => ['api'],
			'namespace' => $this->namespace,
		], function ($router) {

			require __DIR__ . '/routes/api.php';

		});
	}

}
