<?php

namespace Kaleidoscope\Factotum\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Cart;
use Kaleidoscope\Factotum\CartProduct;
use Kaleidoscope\Factotum\CustomerAddress;
use Kaleidoscope\Factotum\Order;
use Kaleidoscope\Factotum\OrderProduct;


trait CartUtils
{
	protected $_cartDuration = '+3 days';

	protected function _getCart()
	{
		try {

			if ( Auth::check() ) {
				$user = Auth::user();

				$cart = Cart::where( 'customer_id', $user->id )->where('expires_at', '>=', date('Y-m-d H:i:s'))->first();

				if ( !$cart ) {
					$cart = new Cart;
					$cart->customer_id = $user->id;
					$cart->expires_at  = date('Y-m-d H:i:s', strtotime( $this->_cartDuration ) );
					$cart->save();
				}

				$cart->load('products');

				return $cart;
			}

			return null;

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return view('factotum::errors.500');
		}
	}


	protected function _getProductCart( $cartId, $productId )
	{
		try {

			$productCart = CartProduct::where( 'cart_id', $cartId )
										->where( 'product_id', $productId )
										->first();

			if ( !$productCart ) {
				$productCart = new CartProduct;
				$productCart->cart_id    = $cartId;
				$productCart->product_id = $productId;
				$productCart->quantity   = 0;
			}

			return $productCart;

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return view('factotum::errors.500');
		}
	}


	protected function _extendCart()
	{
		try {

			if ( Auth::check() ) {
				$user = Auth::user();

				$cart = Cart::where( 'customer_id', $user->id )->where('expires_at', '>=', date('Y-m-d H:i:s'))->first();

				if ( $cart ) {
					$cart->expires_at  = date('Y-m-d H:i:s', strtotime( $this->_cartDuration ) );
					$cart->save();
				}
			}

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return view('factotum::errors.500');
		}
	}


	protected function _getCartTotals( $cart = null )
	{
		$total         = 0;
		$totalPartial  = 0;
		$totalTaxes    = 0;
		$totalShipping = null;
		$totalProducts = 0;

		if ( isset($cart) ) {

			$cartProducts = CartProduct::where( 'cart_id', $cart->id )->get();

			if ( $cartProducts->count() > 0 ) {
				foreach( $cartProducts as $cp ) {
					$totalProducts += $cp->quantity;
					$totalPartial  += $cp->quantity * $cp->product_price;

					if ( $cp->tax_data ) {
						$tax         = $cp->tax_data;
						$totalTaxes += ( ( $cp->quantity * $cp->product_price ) / 100 * $tax['amount'] );
					}
				}

			}

			$total  = $totalPartial;
			$total += $totalTaxes;

			$shipping = $this->_getTemporaryShipping();

			if ( $shipping ) {
				$shippingOptions = $this->_getShippingOptions();
				if ( isset($shippingOptions[$shipping]) ) {
					$totalShipping = $shippingOptions[$shipping]['amount'];
					$total        += $totalShipping;
				}
			}
		}

		return [
			'total'         => $total,
			'totalPartial'  => $totalPartial,
			'totalTaxes'    => $totalTaxes,
			'totalShipping' => $totalShipping,
			'totalProducts' => $totalProducts,
		];
	}


	protected function _getShippingOptions()
	{
		try {

			if ( Auth::check() ) {

				$deliveryAddress = $this->_getTemporaryDeliveryAddress();

				$shippingOptions = config('factotum.shipping_options');

				$tmp = [
					'pick-up' => [
						'amount' => $shippingOptions['pick-up'],
						'label'  => Lang::get('factotum::ecommerce_checkout.shipping_pick_up')
					]
				];

				if ( $deliveryAddress ) {

					if ( isset($shippingOptions[ 'IT' ]) && strtoupper($deliveryAddress->country) == 'IT' ) {
						$tmp['IT'] = [
							'amount' => $shippingOptions['IT'],
							'label'  => Lang::get('factotum::ecommerce_checkout.shipping_italy')
						];
					} else {

						$tmp['abroad'] = [
							'amount' => $shippingOptions['abroad'],
							'label'  => Lang::get('factotum::ecommerce_checkout.shipping_abroad')
						];

					}

				}

				return $tmp;
			}

			return null;

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return view('factotum::errors.500');
		}
	}


	protected function _getTemporaryDeliveryAddress()
	{
		$addressId = request()->session()->get( 'delivery_address' );

		if ( $addressId ) {
			$user = Auth::user();

			return  CustomerAddress::where('customer_id', $user->id)
									->where('type', 'delivery')
									->where('id', $addressId)
									->first();
		}

		return null;
	}


	protected function _getTemporaryInvoiceAddress()
	{
		$addressId = request()->session()->get( 'invoice_address' );

		if ( $addressId ) {
			$user = Auth::user();

			return  CustomerAddress::where('customer_id', $user->id)
									->where('type', 'invoice')
									->where('id', $addressId)
									->first();
		}

		return null;
	}


	protected function _getTemporaryShipping()
	{
		return ( request()->session()->get('shipping') ? request()->session()->get('shipping') : null );
	}


	protected function _createOrderFromCart( Cart $cart )
	{
		try {

			if ( Auth::check() ) {
				$user = Auth::user();

				$totals          = $this->_getCartTotals( $cart );
				$deliveryAddress = $this->_getTemporaryDeliveryAddress();
				$invoiceAddress  = $this->_getTemporaryInvoiceAddress();

				$order = new Order();
				$order->cart_id     = $cart->id;
				$order->customer_id = $user->id;
				$order->status      = 'waiting_payment';

				$order->total_net      = $totals['totalPartial'];
				$order->total_tax      = $totals['totalTaxes'];
				$order->total_shipping = $totals['totalShipping'];

				// TODO: manage discount code on purchasing
				// $order->discount_code_id = $user->id;

				$order->phone = $user->profile->phone;

				$order->delivery_address  = $deliveryAddress->address;
				$order->delivery_city     = $deliveryAddress->city;
				$order->delivery_zip      = $deliveryAddress->zip;
				$order->delivery_province = $deliveryAddress->province;
				$order->delivery_country  = $deliveryAddress->country;

				$order->invoice_address  = $invoiceAddress->address;
				$order->invoice_city     = $invoiceAddress->city;
				$order->invoice_zip      = $invoiceAddress->zip;
				$order->invoice_province = $invoiceAddress->province;
				$order->invoice_country  = $invoiceAddress->country;

				$order->notes = $cart->notes;

				$order->customer_user_agent = $_SERVER['HTTP_USER_AGENT'];
				$order->save();

				// Copy the products from cart to order
				if ( isset($cart) ) {
					$cartProducts = CartProduct::where('cart_id', $cart->id)->get();

					if ( $cartProducts->count() > 0 ) {
						foreach ($cartProducts as $cp) {
							$orderProduct                = new OrderProduct;
							$orderProduct->order_id      = $order->id;
							$orderProduct->product_id    = $cp->product_id;
							$orderProduct->quantity      = $cp->quantity;
							$orderProduct->product_price = $cp->product_price;
							$orderProduct->tax_data      = json_encode( $cp->tax_data );
							$orderProduct->save();
						}
					}
				}

				// Delete the cart
				if ( $order->id ) {
					$cart->order_id = $order->id;
					$cart->save();

					request()->session()->remove('delivery_address');
					request()->session()->remove('invoice_address');
					request()->session()->remove('shipping');

					$cart->delete();
				}

				return $order;
			}

			return null;

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return request()->wantsJson() ? json_encode([
				'result' => 'ko',
				'error'  => $ex->getMessage(),
				'trace' => $ex->getTrace()
			]) : view( $this->_getServerErrorView() );
		}
	}

}