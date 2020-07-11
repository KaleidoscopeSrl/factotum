<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\CustomerAddress;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Library\PayPalClient;
use Kaleidoscope\Factotum\Traits\CartUtils;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;


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
					$cart->payment_type = 'stripe';
					$cart->stripe_intent_id = $intent->id;
					$cart->save();

					$invoiceAddress = $this->_getTemporaryInvoiceAddress();

					$result = [
						'result'         => 'ok',
						'clientSecret'   => $intent->client_secret,
						'billingDetails' => [
							'name'  => $user->profile->company_name,
							'email' => $user->email,
							'phone' => $user->profile->phone,
							'address' => [
								'line1'       => $invoiceAddress->invoice_address,
								'city'        => $invoiceAddress->invoice_city,
								'postal_code' => $invoiceAddress->invoice_zip,
								'state'       => $invoiceAddress->invoice_province,
								'country'     => $invoiceAddress->invoice_country,
							]
						],
						'stripeIntentID' => $intent->id
					];

					return $request->wantsJson() ? json_encode($result) : redirect()->back();
				}

				return $request->wantsJson() ? json_encode([ 'result' => 'ko', 'error' => 'Error on creating order' ]) : view( $this->_getServerErrorView() );
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


	public function getTransactionId( Request $request )
	{
		try {
			$stripeIntentId = $request->input( 'stripe_intent_id' );
			$transactionId  = $request->input('transaction_id');

			$cart = $this->_getCart();

			if ( $stripeIntentId && $cart->stripe_intent_id == $stripeIntentId ) {

				$order = $this->_createOrderFromCart( $cart );
				$order->payment_type   = 'stripe';
				$order->save();

				$order->setTransactionId( $transactionId );
				$order->sendNewOrderNotifications();

				$result = [
					'result'   => 'ok',
					'order_id' => $order->id,
					'redirect' => url('/order/thank-you/' . $order->id )
				];

				return $request->wantsJson() ? json_encode($result) : redirect()->back();

			}

			return $request->wantsJson() ? json_encode([ 'result' => 'ko', 'message' => 'Error on setting stripe transaction id' ]) : view( $this->_getServerErrorView() );

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