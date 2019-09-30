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

    	foreach ( $contentFields as $key => $contentField ){

    		if ( $contentField['options'] ) {

				$tmpOptions = [];

				foreach ( explode(';', $contentField['options'] ) as $tmpOption ) {

					$tmpData = explode( ':', $tmpOption );
					$tmpOptions[] = [
						'name'  => $tmpData[0],
						'label' => $tmpData[1]
					];

				}

				$contentFields[$key]['options'] = $tmpOptions;

			}
		}

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

