<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Kaleidoscope\Factotum\ContentType;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    public function getList()
    {
        $contentTypes = ContentType::withCount('content_fields')->get();

        return response()->json( [ 'result' => 'ok', 'content_types' => $contentTypes ]);
    }


    public function getDetail(Request $request, $id)
    {
        $contentType = ContentType::find($id);

        if ( $contentType ) {
            return response()->json( [ 'result' => 'ok', 'content_type' => $contentType ]);
        }

        return $this->_sendJsonError('Tipo di Contenuto non trovato.');
    }

}

