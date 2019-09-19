<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\ContentType;

class UpdateController extends Controller
{

	public function update(Request $request, $id)
	{
		$this->contentTypeRules['content_type'] .= ',content_type,' . $id;

		$this->_validate( $request );

		$contentType = ContentType::find($id);
		$contentType->old_content_type = $contentType->content_type;

		$contentType = $this->_save( $request, $contentType );

        return response()->json( [ 'result' => 'ok', 'contentType'  => $contentType->toArray() ] );
	}
}