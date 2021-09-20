<?php

namespace Kaleidoscope\Factotum\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\Finder;


class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'Kaleidoscope\\Factotum\\Http\\Controllers';
	protected $apiNamespace = 'Api';

	/**
	 * @var string
	 */
	protected $apiPrefix = 'api/v1';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

	    // Middlewares
		// $this->pushMiddlewareToGroup( 'api', \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class );
		// $this->prependMiddlewareToGroup( 'api', \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class );


        $this->routes(function () {

            Route::prefix( $this->apiPrefix )
                ->middleware('api')
                ->namespace($this->namespace . '\\' . $this->apiNamespace)
	            ->group(function ($router) {
		            $this->registerProtectedApiRoutes();
		            $this->registerPublicApiRoutes();
	            });

//            Route::middleware('web')
//                ->namespace($this->namespace)
//                ->group( base_path('routes/web.php'));

        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }


	/**
	 *
	 */
	protected function registerPublicApiRoutes()
	{
		Route::group([
		],function ($router) {
			$this->mapApiRoutes( FACTOTUM_DIR . '/routes/api/public' );
		});
	}

	/**
	 *
	 */
	protected function registerProtectedApiRoutes()
	{
		Route::group([
			'middleware' => [ 'auth:sanctum' ],
		],function ($router) {
			$this->mapApiRoutes( FACTOTUM_DIR .  '/routes/api/protected' );
		});
	}


	private function mapApiRoutes( $path )
	{
		$finder = new Finder();

		$files = $finder->in($path)
						->files()
						->name('*.php');

		foreach ($files as $file) {
			$routes = $path . '/' . $file->getFilename();
			require $routes;
		}
	}

}
