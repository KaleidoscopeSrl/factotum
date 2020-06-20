<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\CustomerAddress;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Traits\CartUtils;


class StripeController extends Controller
{
	use CartUtils;

	public function __construct()
	{
		\Stripe\Stripe::setApiKey( env('STRIPE_SECRET_KEY') );
	}

	public function initPaymentInit(Request $request)
	{
		try {
			$user   = Auth::user();
			$cart   = $this->_getCart();
			$totals = $this->_getCartTotals( $cart );

			if ( $totals && $totals['total'] > 0 ) {

				$intent = \Stripe\PaymentIntent::create([
					'amount'   => round( $totals['total'] * 100, 0 ), // Stirpe accepts 1099 for a 10.99 payment
					'currency' => 'eur',
				]);

				if ( $intent ) {
					$order = $this->_createOrderFromCart( $cart );

					if ( $order ) {
						$order->payment_type = 'stripe';
						$order->save();

						$result = [
							'result'         => 'ok',
							'clientSecret'   => $intent->client_secret,
							'billingDetails' => [
								'name'  => $user->profile->company_name,
								'email' => $user->email,
								'phone' => $user->profile->phone,
								'address' => [
									'line1'       => $order->invoice_address,
									'city'        => $order->invoice_city,
									'postal_code' => $order->invoice_zip,
									'state'       => $order->invoice_province,
									'country'     => $order->invoice_country,
								]
							],
							'order_id' => $order->id
						];

						return $request->wantsJson() ? json_encode($result) : redirect()->back();
					}

					return $request->wantsJson() ? json_encode([ 'result' => 'ko', 'error' => 'Error on creating order' ]) : view( $this->_getServerErrorView() );
				}
			}

			return $request->wantsJson() ? json_encode([ 'result' => 'ko', 'message' => 'Error on creating intent. Missing cart data' ]) : view( $this->_getServerErrorView() );

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode([
				'result' => 'ko',
				'error' => $ex->getMessage(),
				'trace' => $ex->getTrace()
			]) : view( $this->_getServerErrorView() );
		}

	}


}