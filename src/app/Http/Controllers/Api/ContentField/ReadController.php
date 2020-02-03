<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentField;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentField;


class ReadController extends Controller
{

    public function getList( Request $request, $contentTypeId)
    {
    	$contentFields = ContentField::where( 'content_type_id', $contentTypeId)
										->orderBy('order_no', 'ASC')
										->get();

		return response()->json( [ 'result' => 'ok', 'content_fields' => $contentFields ]);
	}


    public function getDetail(Request $request, $id)
    {
        $contentField = ContentField::find($id);

        if ( $contentField ) {
            return response()->json( [ 'result' => 'ok', 'content_field' => $contentField ]);
        }

        return $this->_sendJsonError( 'Content Field not found', 404 );
    }

}

