<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Library\PayPalClient;

use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;
use Kaleidoscope\Factotum\Traits\CartUtils;

use Kaleidoscope\Factotum\Order;


class PayPalController extends Controller
{
	use CartUtils;


	public function initPaymentInit( Request $request )
	{
		try {
			$user   = Auth::user();
			$cart   = $this->_getCart();
			$totals = $this->_getCartTotals( $cart );

			if ( $totals && $totals['total'] > 0 ) {

				$ppRequest = new OrdersCreateRequest();
				$ppRequest->prefer('return=representation');
				$ppRequest->body = $this->_buildIntentRequestBody( $cart->id, $totals['total'] );

				$client   = PayPalClient::client();
				$response = $client->execute($ppRequest);


				if ( $response->statusCode == 200 || $response->statusCode == 201 ) {
					$order = $this->_createOrderFromCart( $cart );

					if ( $order ) {
						$order->payment_type    = 'paypal';
						$order->paypal_order_id = $response->result->id;
						$order->save();
						$order->sendNewOrderNotifications();

						$result = [
							'result'         => 'ok',
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
							'order_id'      => $order->id,
							'paypalOrderID' => $response->result->id
						];

						return $request->wantsJson() ? json_encode($result) : redirect()->back();
					}
				}

				return $request->wantsJson() ? json_encode([ 'result' => 'ko', 'message' => 'Error on creating intent. Missing cart data' ]) : view( $this->_getServerErrorView() );
			}

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );

			return $request->wantsJson() ? json_encode([
				'result' => 'ko',
				'error' => $ex->getMessage(),
				'trace' => $ex->getTrace()
			]) : view( $this->_getServerErrorView() );
		}

	}


	private function _buildIntentRequestBody( $cartId, $total )
	{
		$deliveryAddress = $this->_getTemporaryDeliveryAddress();

		return [
			'intent' => 'CAPTURE',
			'purchase_units' => [
				0 => [
					'amount' => [
						'currency_code' => 'EUR',
						'value'         => round($total, 2)
					],
					'description' => 'Acquisto su ' . env('APP_NAME'),
					'custom_id'   => $cartId,
					'shipping' => [
						'method'  => 'Corriere Espresso',
						'address' => [
							'address_line_1' => $deliveryAddress->address,
							'admin_area_1'   => $deliveryAddress->province,
							'admin_area_2'   => $deliveryAddress->city,
							'postal_code'    => $deliveryAddress->zip,
							'country_code'   => $deliveryAddress->country,
						]
					]
				]
			]
		];
	}


	public function getTransactionId( Request $request )
	{
		try {
			$user          = Auth::user();
			$orderId       = $request->input('order_id');
			$paypalOrderId = $request->input( 'paypal_order_id' );

			$order = null;
			if ( $orderId ) {
				$order = Order::where('id', $orderId)
								->where('paypal_order_id', $paypalOrderId)
								->where('customer_id', $user->id)
								->first();
			}

			if ( $paypalOrderId && $order ) {

				$client = PayPalClient::client();
				$response = $client->execute(new OrdersGetRequest($paypalOrderId));

				if ( $response->statusCode == 200 || $response->statusCode == 201 ) {

					if ( isset($response->result->purchase_units[0]->payments->captures[0]) ) {
						$transactionId = $response->result->purchase_units[0]->payments->captures[0]->id;

						$order->setTransactionId( $transactionId );

						$result = [
							'result'   => 'ok',
							'order_id' => $order->id,
							'redirect' => url('/order/thank-you/' . $order->id )
						];

						return $request->wantsJson() ? json_encode($result) : redirect()->back();
					}

				}

			}

			return $request->wantsJson() ? json_encode([ 'result' => 'ko', 'message' => 'Error on getting paypal transaction id' ]) : view( $this->_getServerErrorView() );

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