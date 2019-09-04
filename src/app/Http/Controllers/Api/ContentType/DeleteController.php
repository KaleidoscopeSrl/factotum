<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;

class DeleteController extends Controller
{

    public function remove(Request $request, $id)
    {

        $contentType = ContentType::find($id);

        if ( $contentType ) {
            $deletedRows = ContentField::where('content_type_id', $id)->delete();

            if ($deletedRows >= 0) {

                ContentType::destroy($id);

                return response()->json( [ 'result' => 'ok' ]);
            }

            return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
        }

        return $this->_sendJsonError( 'Tipo di Contenuto non trovato.' );
    }

}
