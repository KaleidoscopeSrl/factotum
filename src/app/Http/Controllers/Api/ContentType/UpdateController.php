<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Http\Requests\StoreContentType;

class UpdateController extends Controller
{

	public function update(StoreContentType $request, $id)
	{
		$data = $request->all();

		$contentType = ContentType::find($id);
		$contentType->fill($data);

		if ( $contentType->old_content_type != $contentType->content_type ) {
			$contentType->save();
		}

        return response()->json( [ 'result' => 'ok', 'contentType'  => $contentType->toArray() ] );
	}
}
