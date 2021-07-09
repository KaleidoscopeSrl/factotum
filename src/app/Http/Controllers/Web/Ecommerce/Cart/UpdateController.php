<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;


use Kaleidoscope\Factotum\Http\Requests\AddProductToCart;
use Kaleidoscope\Factotum\Http\Requests\RemoveProductFromCart;
use Kaleidoscope\Factotum\Http\Requests\DropProductFromCart;
use Kaleidoscope\Factotum\Http\Requests\ApplyDiscountCodeOnCart;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;
use Kaleidoscope\Factotum\Traits\EcommerceUtils;
use Kaleidoscope\Factotum\Models\Product;
use Kaleidoscope\Factotum\Models\DiscountCode;
use Kaleidoscope\Factotum\Models\Order;


class UpdateController extends Controller
{

	use EcommerceUtils;


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



	public function applyDiscountCode( ApplyDiscountCodeOnCart $request )
	{
		try {

			$data = $request->all();

			$discountCode = DiscountCode::where( 'code', $data['discount_code'] )->first();
			$usedOnOrders = Order::where('discount_code_id', $discountCode->id)->count();

			if ( $discountCode && $discountCode->amount == $usedOnOrders ) {
				return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => 'Discount Code already used.' ]) : view($this->_getServerErrorView());
			}

			$applicable = false;

			if ( $discountCode->brands && $discountCode->brands->count() > 0 ) {
				$cart = $this->_getCart();

				if ( $cart && $cart->products->count() > 0 ) {
					$tmpBrands = $discountCode->brands->pluck('id')->all();

					foreach ( $cart->products as $product ) {
						if ( in_array( $product->brand_id, $tmpBrands ) ) {
							$applicable = true;
						}
					}
				}
			} else {
				$applicable = true;
			}

			if ( $applicable ) {
				$request->session()->put('discount_code', $discountCode->id );
			}

			return $request->wantsJson() ? json_encode(['result' => 'ok']) : redirect()->back();

		} catch ( \Exception $ex ) {

			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());

		}
	}



	public function removeDiscountCode( Request $request )
	{
		try {

			$request->session()->remove('discount_code');

			return $request->wantsJson() ? json_encode(['result' => 'ok']) : redirect()->back();

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());
		}
	}

}
