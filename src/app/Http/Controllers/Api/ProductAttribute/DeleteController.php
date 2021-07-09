<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductAttribute;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\ProductAttribute;


class DeleteController extends ApiBaseController
{

	public function remove(Request $request, $id)
	{
		$productAttribute = ProductAttribute::find( $id );

		if ( $productAttribute ) {
			$deletedRows = $productAttribute->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Attributo Prodotto non trovato', 404 );
	}


	public function removeProductAttributes(Request $request)
	{
		$productAttributes = $request->input('product_attributes');

		if ( $productAttributes && count($productAttributes) > 0 ) {
			ProductAttribute::whereIn( 'id', $productAttributes )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
