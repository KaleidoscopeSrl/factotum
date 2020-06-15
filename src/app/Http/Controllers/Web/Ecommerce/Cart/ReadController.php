<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Traits\CartUtils;


class ReadController extends Controller
{

	use CartUtils;



	public function ajaxGetCartPanel( Request $request )
	{
		$view   = 'factotum::ecommerce.ajax.cart-panel';
		$cart   = $this->_getCart();
		$totals = $this->_getCartTotals( $cart );


		if ( file_exists( resource_path('views/ecommerce/ajax/cart-panel.blade.php') ) ) {
			$view = 'ecommerce.ajax.cart-panel';
		}

		$returnHTML = view( $view )->with([
			'cart'          => $cart,
			'totalProducts' => $totals['totalProducts'],
			'totalPartial'  => $totals['totalPartial'],
			'totalTaxes'    => $totals['totalTaxes'],
			'totalShipping' => $totals['totalShipping'],
			'total'         => $totals['total'],
		])->render();

		return response()->json([
			'result'        => 'ok',
			'totalProducts' => $totals['totalProducts'],
			'totalPartial'  => '€' . number_format( $totals['totalPartial'], 2, ',', '.' ),
			'totalTaxes'    => '€' . number_format( $totals['totalTaxes'], 2, ',', '.' ),
			'totalShipping' => ( $totals['totalShipping'] ? '€' . number_format( $totals['totalShipping'], 2, ',', '.' ) : '-' ),
			'total'         => '€' . number_format( $totals['total'], 2, ',', '.' ),
			'html'          => $returnHTML
		]);

	}

	public function readCart( Request $request )
	{
		$cart   = $this->_getCart();
		$totals = $this->_getCartTotals( $cart );

		$view = 'factotum::ecommerce.cart';

		if ( file_exists( resource_path('views/ecommerce/cart.blade.php') ) ) {
			$view = 'ecommerce.cart';
		}

		return view($view)->with([
			'cart'          => $cart,
			'totalProducts' => $totals['totalProducts'],
			'totalPartial'  => $totals['totalPartial'],
			'totalTaxes'    => $totals['totalTaxes'],
			'totalShipping' => $totals['totalShipping'],
			'total'         => $totals['total'],
			'metatags' => [
				'title'       => Lang::get('factotum::ecommerce_cart.cart_title'),
				'description' => Lang::get('factotum::ecommerce_cart.cart_description')
			]
		]);
	}


}
