<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;


//use Kaleidoscope\Factotum\Policies\UserPolicy;
//use Kaleidoscope\Factotum\Policies\RolePolicy;
//use Kaleidoscope\Factotum\Policies\CampaignEmailPolicy;
//use Kaleidoscope\Factotum\Policies\CapabilityPolicy;
//use Kaleidoscope\Factotum\Policies\ContentTypePolicy;
//use Kaleidoscope\Factotum\Policies\ContentFieldPolicy;
//use Kaleidoscope\Factotum\Policies\ContentPolicy;
//use Kaleidoscope\Factotum\Policies\MediaPolicy;
//use Kaleidoscope\Factotum\Policies\CategoryPolicy;
//
//use Kaleidoscope\Factotum\Policies\BrandPolicy;
//use Kaleidoscope\Factotum\Policies\ProductCategoryPolicy;
//use Kaleidoscope\Factotum\Policies\ProductPolicy;
//use Kaleidoscope\Factotum\Policies\ProductVariantPolicy;
//use Kaleidoscope\Factotum\Policies\ProductAttributePolicy;
//use Kaleidoscope\Factotum\Policies\ProductAttributeValuePolicy;
//use Kaleidoscope\Factotum\Policies\TaxPolicy;
//use Kaleidoscope\Factotum\Policies\DiscountCodePolicy;
//use Kaleidoscope\Factotum\Policies\InvoicePolicy;
//use Kaleidoscope\Factotum\Policies\OrderPolicy;
//use Kaleidoscope\Factotum\Policies\CustomerAddressPolicy;
//use Kaleidoscope\Factotum\Policies\CartPolicy;
//
//use Kaleidoscope\Factotum\Policies\CampaignPolicy;
//use Kaleidoscope\Factotum\Policies\CampaignTemplatePolicy;
//use Kaleidoscope\Factotum\Policies\NewsletterSubscriptionPolicy;
//
//
//use Kaleidoscope\Factotum\Observers\ContentTypeObserver;
//use Kaleidoscope\Factotum\Observers\ContentFieldObserver;
//use Kaleidoscope\Factotum\Observers\ContentObserver;
//use Kaleidoscope\Factotum\Observers\CategoryObserver;
//use Kaleidoscope\Factotum\Observers\DiscountCodeObserver;
//use Kaleidoscope\Factotum\Observers\OrderObserver;
//use Kaleidoscope\Factotum\Observers\ProductObserver;
//use Kaleidoscope\Factotum\Observers\ProductCategoryObserver;
//use Kaleidoscope\Factotum\Observers\ProductVariantObserver;
//
//
//use Kaleidoscope\Factotum\Console\Commands\FactotumCleanFolders;
//use Kaleidoscope\Factotum\Console\Commands\FactotumMigrateContentTypeAndFields;
//use Kaleidoscope\Factotum\Console\Commands\FactotumMigrateMedia;
//use Kaleidoscope\Factotum\Console\Commands\FactotumMigrateContents;
//use Kaleidoscope\Factotum\Console\Commands\FactotumResetAbsUrl;
//use Kaleidoscope\Factotum\Console\Commands\FactotumCreateStorageFolders;
//use Kaleidoscope\Factotum\Console\Commands\FactotumCreateSymbolicLinks;
//use Kaleidoscope\Factotum\Console\Commands\FactotumInstallation;
//use Kaleidoscope\Factotum\Console\Commands\FactotumGenerateSitemap;
//use Kaleidoscope\Factotum\Console\Commands\FactotumGenerateProductImages;
//use Kaleidoscope\Factotum\Console\Commands\FactotumGenerateProductAttributesIndex;
//use Kaleidoscope\Factotum\Console\Commands\DumpAutoload;
//
//use Kaleidoscope\Factotum\Models\User;
//use Kaleidoscope\Factotum\Models\Role;
//use Kaleidoscope\Factotum\Models\Capability;
//use Kaleidoscope\Factotum\Models\ContentType;
//use Kaleidoscope\Factotum\Models\ContentField;
//use Kaleidoscope\Factotum\Models\Content;
//use Kaleidoscope\Factotum\Models\Media;
//use Kaleidoscope\Factotum\Models\Category;
//
//use Kaleidoscope\Factotum\Models\Brand;
//use Kaleidoscope\Factotum\Models\ProductCategory;
//use Kaleidoscope\Factotum\Models\Product;
//use Kaleidoscope\Factotum\Models\ProductVariant;
//use Kaleidoscope\Factotum\Models\ProductAttribute;
//use Kaleidoscope\Factotum\Models\ProductAttributeValue;
//use Kaleidoscope\Factotum\Models\Tax;
//use Kaleidoscope\Factotum\Models\DiscountCode;
//use Kaleidoscope\Factotum\Models\Invoice;
//use Kaleidoscope\Factotum\Models\Order;
//use Kaleidoscope\Factotum\Models\Cart;
//use Kaleidoscope\Factotum\Models\CustomerAddress;
//
//use Kaleidoscope\Factotum\Models\Campaign;
//use Kaleidoscope\Factotum\Models\CampaignEmail;
//use Kaleidoscope\Factotum\Models\CampaignTemplate;


class FactotumServiceProvider extends ServiceProvider
{

	protected $policies = [
//		Role::class          => RolePolicy::class,
//		Capability::class    => CapabilityPolicy::class,
//		ContentType::class   => ContentTypePolicy::class,
//		ContentField::class  => ContentFieldPolicy::class,
//		Content::class       => ContentPolicy::class,
//		Media::class         => MediaPolicy::class,
//		Category::class      => CategoryPolicy::class,
	];


	protected function registerConfig()
	{
		$this->app['config']->set( 'factotum',
			array_replace_recursive(
				require FACTOTUM_DIR . '/config/factotum.php',
				( file_exists( base_path('config/factotum.php')) ? require base_path('config/factotum.php') : [] ),
			)
		);

		$this->app['config']->set( 'modules',
			array_replace_recursive(
				require FACTOTUM_DIR . '/config/modules.php',
				( file_exists( base_path('config/modules.php')) ? require base_path('config/modules.php') : [] ),
			)
		);

		if ( !file_exists( config_path('scribe.php') ) ) {
			File::copy( FACTOTUM_DIR . '/config/scribe.php', config_path('scribe.php'));
		}

		$this->app['config']->set( 'scribe',
			array_replace_recursive(
				require FACTOTUM_DIR . '/config/scribe.php',
				( file_exists( base_path('config/scribe.php')) ? require base_path('config/scribe.php') : [] ),
			)
		);

		$this->app['config']->set( 'auth',
			array_replace_recursive(
				require FACTOTUM_DIR . '/config/auth.php',
				( file_exists( base_path('config/auth.php')) ? require base_path('config/auth.php') : [] ),
			)
		);
	}



	public function boot(GateContract $gate)
	{
		if ( !defined('FACTOTUM_DIR') ) {
			define( 'FACTOTUM_DIR', __DIR__ );
		}

		Schema::defaultStringLength(191);

		$this->registerConfig();


		$this->app->register(\Laravel\Sanctum\SanctumServiceProvider::class);
		$this->app->register(\Kaleidoscope\Factotum\Providers\AuthServiceProvider::class);
		$this->app->register(\Kaleidoscope\Factotum\Providers\RouteServiceProvider::class);
		// $this->app->register(\Kaleidoscope\Factotum\Modules\Cms\Providers\CmsServiceProvider::class);








//		if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {
//			$policies[] = [
//				Brand::class                  => BrandPolicy::class,
//				ProductCategory::class        => ProductCategoryPolicy::class,
//				Product::class                => ProductPolicy::class,
//				ProductVariant::class         => ProductVariantPolicy::class,
//				ProductAttribute::class       => ProductAttributePolicy::class,
//				ProductAttributeValue::class  => ProductAttributeValuePolicy::class,
//				Tax::class                    => TaxPolicy::class,
//				DiscountCode::class           => DiscountCodePolicy::class,
//				Invoice::class                => InvoicePolicy::class,
//				Order::class                  => OrderPolicy::class,
//				Cart::class                   => CartPolicy::class,
//				CustomerAddress::class        => CustomerAddressPolicy::class
//			];
//		}
//
//		if ( env('FACTOTUM_NEWSLETTER_INSTALLED') ) {
//			$policies[] = [
//				Campaign::class                 => CampaignPolicy::class,
//				CampaignTemplate::class         => CampaignTemplatePolicy::class,
//				CampaignEmail::class            => CampaignEmailPolicy::class,
//				NewsletterSubscription::class   => NewsletterSubscriptionPolicy::class
//			];
//		}

//		// Migrations & Seeds
//		// $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
//
//
//		// Configurations

//
//		$this->app['config']->set( 'cors', array_merge(
//			$this->app['config']->get('cors', []), require __DIR__ . '/config/cors.php'
//		));
//
//		$this->app['config']->set( 'database', array_merge(
//			require __DIR__ . '/config/database.php',
//			$this->app['config']->get('database', [])
//		));
//
//		$this->app['config']->set( 'mail', array_replace_recursive(
//			require __DIR__ . '/config/mail.php',
//			$this->app['config']->get('mail', [])
//		));
//
//		$this->app['config']->set( 'view', array_merge(
//			$this->app['config']->get('view', []), require __DIR__ . '/config/view.php'
//		));
//
//		$this->app['config']->set( 'filesystems', array_replace_recursive(
//			require __DIR__ . '/config/filesystems.php',
//			$this->app['config']->get('filesystems', []),
//		));



		// Middlewares
//		$this->getRouter()->pushMiddlewareToGroup('session_start',      \Illuminate\Session\Middleware\StartSession::class);
//		$this->getRouter()->pushMiddlewareToGroup('preflight',          \Kaleidoscope\Factotum\Http\Middleware\PreflightResponse::class);
//		$this->getRouter()->pushMiddlewareToGroup('uncomplete_profile', \Kaleidoscope\Factotum\Http\Middleware\UncompleteProfile::class);
//		$this->getRouter()->pushMiddlewareToGroup('cors',               \Fruitcake\Cors\HandleCors::class);
//		$this->getRouter()->pushMiddlewareToGroup('add_access_token',   \Kaleidoscope\Factotum\Http\Middleware\AddHeaderAccessToken::class);



//		// Config, Resources and Public
//		$this->publishes([
//			// CONFIG
//			__DIR__ . '/config/factotum.php'  => config_path('factotum.php'),
//
//			// WEB APP
//			__DIR__ . '/public/admin'         => public_path('admin'),
//
//			// MINISITE
////			__DIR__ . '/public/assets'        => public_path('assets'),
//			__DIR__ . '/public/robots.txt'    => public_path(''),
//		], 'factotum');
//
//		$this->publishes([
//			// VIEWS
//			__DIR__ . '/resources/views'      => resource_path( 'views' )
//		], 'factotum-views');
//
//
//		$this->publishes([
//			// LANGS
//			__DIR__ . '/resources/lang'      => resource_path( 'lang' )
//		], 'factotum-langs');
//
//
//		$this->loadViewsFrom(__DIR__ . '/resources/views', 'factotum');
//		$this->loadTranslationsFrom( __DIR__ . '/resources/lang', 'factotum' );
//
//		if ( $this->app->runningInConsole() ) {
//
//			$this->commands([
//				FactotumCleanFolders::class,
//				FactotumResetAbsUrl::class,
//				FactotumMigrateMedia::class,
//				FactotumMigrateContentTypeAndFields::class,
//				FactotumMigrateContents::class,
//				DumpAutoload::class,
//				FactotumCreateStorageFolders::class,
//				FactotumCreateSymbolicLinks::class,
//				FactotumInstallation::class,
//				FactotumGenerateSitemap::class,
//				FactotumGenerateProductImages::class,
//				FactotumGenerateProductAttributesIndex::class
//			]);
//
//		}
//
//
//		// Models
//		ContentType::observe(ContentTypeObserver::class);
//		ContentField::observe(ContentFieldObserver::class);
//		Content::observe(ContentObserver::class);
//		Category::observe(CategoryObserver::class);
//
//		if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {
//			Order::observe(OrderObserver::class);
//			Product::observe(ProductObserver::class);
//			ProductCategory::observe(ProductCategoryObserver::class);
//			ProductVariant::observe(ProductVariantObserver::class);
//			DiscountCode::observe(DiscountCodeObserver::class);
//		}


		// Final pieces and boobs
		// $this->_addValidators();
	}




	private function _setupRoutes()
	{
//		Passport::routes();
//		Passport::enableImplicitGrant();

//		// Public Routes
//		Route::group([
//			'prefix'     => 'api/v1',
//			'middleware' => [
//				'api',
//				'session_start',
//			],
//			'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Api'
//		], function ($router) {
//			require __DIR__ . '/routes/api/public/api.php';
//			require __DIR__ . '/routes/api/public/auth.php';
//
//			if ( env('FACTOTUM_NEWSLETTER_INSTALLED') ) {
//				require __DIR__ . '/routes/api/public/mailgun.php';
//			}
//		});

		// Protected Routes
//		Route::group([
//			'prefix'     => 'api/v1',
//			'middleware' => [
//				'add_access_token',
//				'api',
//				'auth:api',
//				'cors',
//				'session_start'
//			],
//			'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Api'
//		], function ($router) {
//			require __DIR__ . '/routes/api/auth.php';
//
//			if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {
//				require __DIR__ . '/routes/api/brand.php';
//				require __DIR__ . '/routes/api/product-category.php';
//				require __DIR__ . '/routes/api/product-attribute.php';
//				require __DIR__ . '/routes/api/product-attribute-value.php';
//				require __DIR__ . '/routes/api/product-variant.php';
//				require __DIR__ . '/routes/api/product.php';
//				require __DIR__ . '/routes/api/customer-address.php';
//				require __DIR__ . '/routes/api/order.php';
//				require __DIR__ . '/routes/api/invoice.php';
//				require __DIR__ . '/routes/api/cart.php';
//				require __DIR__ . '/routes/api/tax.php';
//				require __DIR__ . '/routes/api/discount-code.php';
//			}
//
//			if ( env('FACTOTUM_NEWSLETTER_INSTALLED') ) {
//				require __DIR__ . '/routes/api/campaign.php';
//				require __DIR__ . '/routes/api/campaign-template.php';
//				require __DIR__ . '/routes/api/campaign-email.php';
//				require __DIR__ . '/routes/api/newsletter-subscription.php';
//			}
//
//			require __DIR__ . '/routes/api/capability.php';
//			require __DIR__ . '/routes/api/category.php';
//			require __DIR__ . '/routes/api/content.php';
//			require __DIR__ . '/routes/api/content-type.php';
//			require __DIR__ . '/routes/api/content-field.php';
//			require __DIR__ . '/routes/api/media.php';
//			require __DIR__ . '/routes/api/role.php';
//			require __DIR__ . '/routes/api/setting.php';
//			require __DIR__ . '/routes/api/user.php';
//			require __DIR__ . '/routes/api/utility.php';
//			require __DIR__ . '/routes/api/tool.php';
//		});



//		$factotumNs = 'Kaleidoscope\Factotum\Http\Controllers\Web';
//
//		$overridingRoutes = false;
//
//		// Frontend Auth Routes
//		if ( !file_exists( base_path('routes') . '/web/auth.php' ) ) {
//
//			Route::group([
//				'middleware' => [ 'web' ],
//				'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Web\Auth'
//			], function ($router) {
//				require __DIR__ . '/routes/web/public/auth.php';
//				require __DIR__ . '/routes/web/auth.php';
//			});
//
//			$overridingRoutes = true;
//		}
//
//		// Frontend User Routes
//		if ( !file_exists( base_path('routes') . '/web/user.php' ) ) {
//
//			Route::group([
//				'middleware' => [ 'web' ],
//				'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Web\User'
//			], function ($router) {
//				require __DIR__ . '/routes/web/public/user.php';
//				require __DIR__ . '/routes/web/user.php';
//			});
//
//			$overridingRoutes = true;
//		}
//
//
//		if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {
//
//			// Frontend Cart Routes
//			if ( !file_exists( base_path('routes') . '/web/ecommerce/cart.php' ) ) {
//
//				Route::group([
//					'middleware' => [ 'web' ],
//					'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Cart'
//				], function ($router) {
//					require __DIR__ . '/routes/web/public/ecommerce/cart.php';
//					require __DIR__ . '/routes/web/ecommerce/cart.php';
//				});
//
//				$overridingRoutes = true;
//			}
//
//			// Frontend Checkout Routes
//			if ( !file_exists( base_path('routes') . '/web/ecommerce/checkout.php' ) ) {
//
//				Route::group([
//					'middleware' => [
//						'web',
//						'uncomplete_profile'
//					],
//					'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Checkout'
//				], function ($router) {
//					require __DIR__ . '/routes/web/ecommerce/checkout.php';
//				});
//
//				$overridingRoutes = true;
//			}
//
//			// Frontend Payment Routes
//			if ( !file_exists( base_path('routes') . '/web/ecommerce/payment.php' ) ) {
//
//				Route::group([
//					'middleware' => [
//						'web',
//						'uncomplete_profile'
//					],
//					'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Payment'
//				], function ($router) {
//					require __DIR__ . '/routes/web/ecommerce/payment.php';
//				});
//
//				$overridingRoutes = true;
//			}
//
//			// Frontend Order Routes
//			if ( !file_exists( base_path('routes') . '/web/ecommerce/order.php' ) ) {
//
//				Route::group([
//					'middleware' => [ 'web' ],
//					'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Order'
//				], function ($router) {
//					require __DIR__ . '/routes/web/ecommerce/order.php';
//				});
//
//				$overridingRoutes = true;
//			}
//
//			// Frontend Product Routes
//			if ( !file_exists( base_path('routes') . '/web/ecommerce/product.php' ) ) {
//
//				Route::group([
//					'middleware' => [ 'web' ],
//					'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Product'
//				], function ($router) {
//					require __DIR__ . '/routes/web/public/ecommerce/product.php';
//				});
//
//				$overridingRoutes = true;
//			}
//
//			// Frontend Ecommerce User Routes
//			if ( !file_exists( base_path('routes') . '/web/ecommerce/user.php' ) ) {
//
//				Route::group([
//					'middleware' => [ 'web' ],
//					'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\User'
//				], function ($router) {
//					require __DIR__ . '/routes/web/ecommerce/user.php';
//				});
//
//				$overridingRoutes = true;
//			}
//
//		}
//
//		if ( !file_exists( base_path('routes') . '/web/public/web.php' ) ) {
//			require __DIR__ . '/routes/web/public/web.php';
//
//			$overridingRoutes = true;
//		}
	}


//	private function _addValidators()
//	{
//		Validator::extend('allowed_types', function($attribute, $value, $parameters, $validator) {
//			if ( $value == '["*"]' ) {
//				return true;
//			}
//
//			$value = json_decode( $value, true );
//
//			if ($value && count($value) > 0) {
//				$error = false;
//				foreach ($value as $format) {
//					if (strlen($format) < 3) {
//						$error = true;
//					}
//				}
//				return !$error;
//			}
//
//			return $value == 'foo';
//		});
//
//		Validator::extend('max_mb', function($attribute, $value, $parameters, $validator) {
//			if ( $value instanceof UploadedFile && ! $value->isValid() ) {
//				return false;
//			}
//
//			// If call getSize()/1024/1024 on $value here it'll be numeric and not
//			// get divided by 1024 once in the Validator::getSize() method.
//			$megabytes = $value->getSize() / 1024 / 1024;
//
//			return $megabytes <= $parameters[0];
//		});
//
//		Validator::replacer('max_mb', function($message, $attribute, $rule, $parameters) {
//			return str_replace(array(':attribute', ':max'), array($attribute, $parameters[0]), $message);
//		});
//	}


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

