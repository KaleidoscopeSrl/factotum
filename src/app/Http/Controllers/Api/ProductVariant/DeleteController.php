<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductVariant;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\ProductVariant;

class DeleteController extends Controller
{

	public function remove(Request $request, $id)
	{
		$productVariant = ProductVariant::find( $id );

		if ( $productVariant ) {
			$deletedRows = $productVariant->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Variante Prodotto non trovata', 404 );
	}


	public function removeProductVariants(Request $request)
	{
		$productVariants = $request->input('product_variants');

		if ( $productVariants && count($productVariants) > 0 ) {
			ProductVariant::whereIn( 'id', $productVariants )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
