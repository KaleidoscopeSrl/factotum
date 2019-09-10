<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentField;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\ContentType;


class ReadController extends Controller
{

    public function getList()
    {
        $contentFields = ContentType::with( ['content_fields' => function($query) {
            $query->orderBy('order_no', 'ASC');
        }])->get();

        return response()->json( [ 'result' => 'ok', 'content_fields' => $contentFields ]);
    }


    public function getDetail(Request $request, $id)
    {
        $contentField = ContentField::find($id);

        if ( $contentField ) {
            return response()->json( [ 'result' => 'ok', 'content_field' => $contentField ]);
        }

        return $this->_sendJsonError('Campo non trovato.');
    }


}

