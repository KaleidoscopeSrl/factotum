<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Category;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\Category;

class DeleteController extends ApiBaseController
{

    public function remove(Request $request, $id)
	{
        $category = Category::find( $id );

        if ( $category ) {
            $deletedRows = $category->delete();

            if ( $deletedRows > 0 ) {
                return response()->json( [ 'result' => 'ok' ]);
            }
            return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
        }

        return $this->_sendJsonError( 'Categoria non trovata.' );
	}

}
