<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Kaleidoscope\Factotum\ContentType;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    public function getList()
    {
        $contentTypes = ContentType::get();

        return response()->json( [ 'result' => 'ok', 'contentTypes' => $contentTypes ]);
    }

    public function getDetail(Request $request, $id)
    {
        $contentType = ContentType::find($id);

        if ( $contentType ) {
            return response()->json( [ 'result' => 'ok', 'contentType' => $contentType ]);
        }

        return $this->_sendJsonError('Tipo di Contenuto non trovato.');
    }
}

