<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentField;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\ContentField;
use Kaleidoscope\Factotum\Models\ContentType;


class ReadController extends ApiBaseController
{

    public function getList( Request $request, $contentTypeId)
    {
    	$contentFields = ContentField::where( 'content_type_id', $contentTypeId)
										->orderBy('order_no', 'ASC')
										->get();

    	if ( $contentFields->count() > 0 ) {

    		foreach ( $contentFields as $cf ) {

    			// If the "content type to list" field does not have options, I fill with the content types
    			if ( $cf->name == 'content_type_to_list' && !$cf->options ) {

					$contentTypes = ContentType::orderBy('order_no', 'asc')->get();

					$tmp = [];

					if ( $contentTypes->count() > 0 ) {
						foreach ( $contentTypes as $ct ) {
							$tmp[] = [
								'value' => $ct->id,
								'label' => $ct->content_type
							];
						}
					}

					$cf->options = json_encode( $tmp );

				}
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

        return $this->_sendJsonError( 'Content Field not found', 404 );
    }

}

