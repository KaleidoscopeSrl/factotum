<?php

namespace Kaleidoscope\Factotum\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Cart;
use Kaleidoscope\Factotum\CartProduct;
use Kaleidoscope\Factotum\CustomerAddress;


trait CartUtils
{

	protected function _getCart()
	{
		try {

			if ( Auth::check() ) {
				$user = Auth::user();

				$cart = Cart::where( 'customer_id', $user->id )->where('expires_at', '>=', date('Y-m-d H:i:s'))->first();

				if ( !$cart ) {
					$cart = new Cart;
					$cart->customer_id = $user->id;
					$cart->expires_at  = date('Y-m-d H:i:s', strtotime('+1 day') );
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
					$cart->expires_at  = date('Y-m-d H:i:s', strtotime('+1 day') );
					$cart->save();
				}
			}

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return view('factotum::errors.500');
		}
	}


	protected function _getCartTotals( Cart $cart )
	{
		$total         = 0;
		$totalPartial  = 0;
		$totalTaxes    = 0;
		$totalShipping = null;
		$totalProducts = 0;

		if ( isset($cart) && $cart->products->count() > 0 ) {

			foreach( $cart->products as $p ) {
				$totalProducts += $p->pivot->quantity;
				$totalPartial  += $p->pivot->quantity * $p->pivot->product_price;
				$total         += $totalPartial;

				if ( $p->pivot->tax_data ) {
					$tax         = json_decode( $p->pivot->tax_data, true );
					$totalTaxes += ( ( $p->pivot->quantity * $p->pivot->product_price ) / 100 * $tax['amount'] );
					$total      += $totalTaxes;
				}
			}

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
			$user      = Auth::user();

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
			$user      = Auth::user();

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

}