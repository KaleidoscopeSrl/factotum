<?php
namespace Kaleidoscope\Factotum\Library;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PayPalClient
{

	public static function client()
	{
		return new PayPalHttpClient(self::environment());
	}

	public static function environment()
	{
		$clientId     = env('PAYPAL_CLIENT_ID');
		$clientSecret = env('PAYPAL_CLIENT_SECRET');

		if ( $clientId && $clientSecret ) {
			if ( env('APP_ENV') == 'production' ) {
				return new ProductionEnvironment( $clientId, $clientSecret );
			}

			return new SandboxEnvironment( $clientId, $clientSecret );
		}

		return null;
	}

}