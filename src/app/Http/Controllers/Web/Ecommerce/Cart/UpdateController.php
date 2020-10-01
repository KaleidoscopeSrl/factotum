<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Cart;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\DiscountCode;
use Kaleidoscope\Factotum\Http\Requests\AddProductToCart;
use Kaleidoscope\Factotum\Http\Requests\RemoveProductFromCart;
use Kaleidoscope\Factotum\Http\Requests\DropProductFromCart;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\Tax;
use Kaleidoscope\Factotum\Traits\CartUtils;


class UpdateController extends Controller
{

	use CartUtils;


    public function addProduct( AddProductToCart $request )
    {
		try {

			$productId = $request->input('product_id');
			$quantity  = $request->input('quantity');
			$product   = Product::find($productId);

			if ( $product->has_variants ) {
				$productVariantId = $request->input('product_variant_id');
			}

			$result = $this->addProductToCart( $productId, $quantity, $productVariantId );

			if ( $result['result'] == 'ok' ) {
				session()->flash( 'product_added', $result['message'] );
				return $request->wantsJson() ? response()->json( $result ) : redirect()->back();
			} else {
				session()->flash( 'error', $result['message'] );
				return $request->wantsJson() ? response()->json(['result' => 'ko', 'error' => $result['message'] ], 403) : view($this->_getServerErrorView());
			}

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? response()->json(['result' => 'ko', 'error' => $ex->getMessage() ], 403) : view($this->_getServerErrorView());
		}

    }



	public function removeProduct( RemoveProductFromCart $request )
	{
		try {

			$productId = $request->input('product_id');
			$quantity  = $request->input('quantity');
			$product   = Product::find($productId);

			if ( $product->has_variants ) {
				$productVariantId = $request->input('product_variant_id');
			}

			$result = $this->removeProductFromCart( $productId, $quantity, $productVariantId );

			session()->flash( 'product_removed', Lang::get('factotum::ecommerce_cart.product_removed') );

			return $request->wantsJson() ? json_encode( $result ) : redirect()->back();

		} catch ( \Exception $ex ) {

			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());

		}
	}



	public function dropProduct( DropProductFromCart $request )
	{
		try {

			$productId = $request->input('product_id');
			$product   = Product::find($productId);

			if ( $product->has_variants ) {
				$productVariantId = $request->input('product_variant_id');
			}

			$result = $this->dropProductFromCart( $productId, $productVariantId );

			if ( $result['result'] == 'ok' ) {
				session()->flash( 'product_dropped', Lang::get('factotum::ecommerce_cart.product_dropped') );
			} else {
				session()->flash( 'error', Lang::get('factotum::ecommerce_cart.product_drop_error') );
			}

			return $request->wantsJson() ? json_encode($result) : redirect()->back();

		} catch ( \Exception $ex ) {

			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());

		}
	}


}
