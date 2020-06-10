<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Cart;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Traits\CartUtils;


class ReadController extends Controller
{

	use CartUtils;

	public function ajaxGetCartPanel( Request $request )
	{
		$view = 'factotum::ecommerce.ajax.cart-panel';
		$cart = $this->_getCart();

		$total = 0;
		$totalProducts = 0;

		if ( isset($cart) && isset($cart->products) && $cart->products->count() > 0 ) {
			foreach( $cart->products as $p ) {
				$totalProducts += $p->pivot->quantity;
				$total += $p->pivot->quantity * $p->pivot->product_price;
			}
		}

		if ( file_exists( resource_path('views/ecommerce/ajax/cart-panel.blade.php') ) ) {
			$view = 'ecommerce.ajax.cart-panel';
		}

		$returnHTML = view( $view )->with([
			'total' => $total,
			'cart'  => $cart
		])->render();

		return response()->json([
			'result'        => 'ok',
			'total'         => '€' . number_format( $total, 2, ',', '.' ),
			'totalProducts' => $totalProducts,
			'html'          => $returnHTML
		]);

	}


	public function getCart( Request $request )
	{
		$cart          = $this->_getCart();
		$total         = 0;
		$totalProducts = 0;

		if ( isset($cart) && $cart->products->count() > 0 ) {
			foreach( $cart->products as $p ) {
				$totalProducts += $p->pivot->quantity;
				$total += $p->pivot->quantity * $p->pivot->product_price;
			}
		}

		$view = 'factotum::ecommerce.cart';

		if ( file_exists( resource_path('views/ecommerce/cart.blade.php') ) ) {
			$view = 'ecommerce.cart';
		}

		return view($view)->with([
			'cart'          => $cart,
			'total'         => '€ ' . number_format( $total, 2, ',', '.' ),
			'totalProducts' => $totalProducts
		]);
	}


}
