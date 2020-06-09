<?php

namespace Kaleidoscope\Factotum\Traits;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Cart;
use Kaleidoscope\Factotum\CartProduct;

trait CartUtils
{

	protected function _getCart()
	{
		try {

			if ( Auth::check() ) {
				$user = Auth::user();

				$cart = Cart::where( 'customer_id', $user->id )
					->where('expires_at', '>=', date('Y-m-d H:i:s'))->first();

				if ( !$cart ) {
					$cart = new Cart;
					$cart->customer_id = $user->id;
					$cart->expires_at  = date('Y-m-d H:i:s', strtotime('+1 day') );
					$cart->total       = 0;
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

}