<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductAttributeValue;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\ProductAttributeValue;


class DeleteController extends ApiBaseController
{

	public function remove(Request $request, $id)
	{
		$productAttributeValue = ProductAttributeValue::find( $id );

		if ( $productAttributeValue ) {
			$deletedRows = $productAttributeValue->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Valore Attributo Prodotto non trovato', 404 );
	}


	public function removeProductAttributeValues(Request $request)
	{
		$productAttributeValues = $request->input('product_attribute_values');

		if ( $productAttributeValues && count($productAttributeValues) > 0 ) {
			ProductAttributeValue::whereIn( 'id', $productAttributeValues )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
