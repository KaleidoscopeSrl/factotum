<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductCategory;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\ProductCategory;

class DeleteController extends Controller
{

    public function remove(Request $request, $id)
	{
        $productCategory = ProductCategory::find( $id );

        if ( $productCategory ) {
            $deletedRows = $productCategory->delete();

            if ( $deletedRows > 0 ) {
                return response()->json( [ 'result' => 'ok' ]);
            }
            return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
        }

        return $this->_sendJsonError( 'Categoria Prodotto non trovata.' );
	}

}
