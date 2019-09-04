<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentField;

use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\ContentType;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    public function getList()
    {
        $contentTypes = ContentType::with(array('content_fields' => function($query) {
            $query->orderBy('order_no', 'ASC');
        }))->get();

        return response()->json( [ 'result' => 'ok', 'contentTypes' => $contentTypes ]);
    }

    public function getDetail(Request $request, $id)
    {
        $contentField = ContentField::find($id);

        if ( $contentField ) {
            return response()->json( [ 'result' => 'ok', 'contentField' => $contentField ]);
        }

        return $this->_sendJsonError('Categoria non trovata.');
    }

}

