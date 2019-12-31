<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentField;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\ContentField;

class DeleteController extends Controller
{

    public function remove(Request $request, $id)
    {

        $contentField = ContentField::find( $id );

        if ( $contentField ) {

            $deletedRows = $contentField->delete();

            if ( $deletedRows > 0 ) {
                return response()->json( [ 'result' => 'ok' ]);
            }
            return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
        }

        return $this->_sendJsonError( 'Campo non trovato.' );

    }

}
