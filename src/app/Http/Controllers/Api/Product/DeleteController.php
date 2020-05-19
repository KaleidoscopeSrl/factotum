<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Product;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Product;


class DeleteController extends Controller
{

	public function remove(Request $request, $id)
	{
		$product = Product::find( $id );

		if ( $product ) {
			$deletedRows = $product->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Product not found', 404 );
	}


	public function removeProducts(Request $request)
	{
		$products   = $request->input('products');

		if ( $products && count($products) > 0 ) {
			Product::whereIn( 'id', $products )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
