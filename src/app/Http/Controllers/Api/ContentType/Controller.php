<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

class Controller extends ApiBaseController
{

    protected function validator( Request $request, array $data, $id = null )
    {
        $rules = array(
            'content_type' => 'required|max:32|unique:content_types|not_in:' . join(',', config('app.prohibited_content_types') )
        );
        if ( $id ) {
            $contentType = ContentType::find($id);
            if ( $data['content_type'] == $contentType->content_type ) {
                $rules = array(
                    'content_type' => 'required|max:32|not_in:' . join(',', config('factotum.factotum.prohibited_content_types') )
                );
            }
        }
        return Validator::make($data, $rules);
    }

	protected function _save( Request $request, $contentType )
	{
		$data = $request->all();

		$contentType->content_type = strtolower($data['content_type']);
		if ( $contentType->old_content_type != $contentType->content_type ) {
			$contentType->save();
		}

		return $contentType;
	}
}
