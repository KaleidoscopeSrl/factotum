<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\CartProduct;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Traits\CartUtils;


class ReadController extends Controller
{

	use CartUtils;


	public function ajaxGetCartPanel( Request $request )
	{
		$view   = 'factotum::ecommerce.ajax.cart-panel';
		$cart   = $this->_getCart();

		$result = [
			'result'        => 'ok',
			'totalProducts' => 0,
			'totalDiscount' => 0,
			'totalPartial'  => 0,
			'totalTaxes'    => 0,
			'totalShipping' => 0,
			'total'         => 0,
			'html'          => ''
		];
		
		$cartPage = $request->input('cart_page');

		if ( $cart ) {
			$totals       = $this->_getCartTotals( $cart );
			$cartProducts = CartProduct::where( 'cart_id', $cart->id )->get();

			if ( file_exists( resource_path('views/ecommerce/ajax/cart-panel.blade.php') ) ) {
				$view = 'ecommerce.ajax.cart-panel';
			}

			$returnHTML = view( $view )->with([
				'cart'          => $cart,
				'cartProducts'  => $cartProducts,
				'totalProducts' => $totals['totalProducts'],
				'totalDiscount' => $totals['totalDiscount'],
				'totalPartial'  => $totals['totalPartial'],
				'totalTaxes'    => $totals['totalTaxes'],
				'totalShipping' => $this->_getTotalShipping( $totals['total'], $totals['totalShipping'], true ),
				'total'         => $totals['total'],
				'cartPage'      => $cartPage,
				'discountCode'  => $this->_getTemporaryDiscountCode(),
			])->render();

			$result = [
				'result'        => 'ok',
				'cart_id'       => $cart->id,
				'totalProducts' => $totals['totalProducts'],
				'totalDiscount' => '€' . number_format( $totals['totalDiscount'], 2, ',', '.' ),
				'totalPartial'  => '€' . number_format( $totals['totalPartial'], 2, ',', '.' ),
				'totalTaxes'    => '€' . number_format( $totals['totalTaxes'], 2, ',', '.' ),
				'totalShipping' => $this->_getTotalShipping( $totals['total'], $totals['totalShipping'], true ),
				'total'         => '€' . number_format( $totals['total'], 2, ',', '.' ),
				'html'          => $returnHTML
			];

		}

		return response()->json( $result );
	}


	public function readCart( Request $request )
	{
		$cart         = $this->_getCart();
		$totals       = $this->_getCartTotals( $cart );
		$cartProducts = CartProduct::where( 'cart_id', $cart->id )->get();

		$view = 'factotum::ecommerce.cart.cart';

		if ( file_exists( resource_path('views/ecommerce/cart/cart.blade.php') ) ) {
			$view = 'ecommerce.cart.cart';
		}

		return view($view)->with([
			'cart'          => $cart,
			'cartProducts'  => $cartProducts,
			'totalProducts' => $totals['totalProducts'],
			'totalDiscount' => $totals['totalDiscount'],
			'totalPartial'  => $totals['totalPartial'],
			'totalTaxes'    => $totals['totalTaxes'],
			'totalShipping' => $this->_getTotalShipping( $totals['total'], $totals['totalShipping'], true ),
			'total'         => $totals['total'],
			'discountCode'  => $this->_getTemporaryDiscountCode(),
			'metatags' => [
				'title'       => Lang::get('factotum::ecommerce_cart.cart_title'),
				'description' => Lang::get('factotum::ecommerce_cart.cart_description')
			]
		]);
	}


}
