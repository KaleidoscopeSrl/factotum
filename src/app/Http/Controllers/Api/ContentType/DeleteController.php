<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;

class DeleteController extends Controller
{

    public function remove(Request $request, $id)
    {
        $contentType = ContentType::find($id);

        if ( $contentType ) {
            $deletedRows = ContentField::where('content_type_id', $id)->delete();

            if ( $deletedRows >= 0 ) {
                ContentType::destroy($id);

                return response()->json( [ 'result' => 'ok' ]);
            }

            return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
        }

        return $this->_sendJsonError( 'Content Type not found', 404 );
    }

}
