<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

class Controller extends ApiBaseController
{

	protected $contentTypeRules = [
		'content_type' => 'required|max:32|unique:content_types',
	];



	protected function _validate( $request )
	{
		$this->contentTypeRules['content_type'] .= '|not_in:' . join(',', config('factotum.prohibited_content_types') );

		return $this->validate($request, $this->contentTypeRules, $this->messages);
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
