<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentField;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreContentField;
use Kaleidoscope\Factotum\Models\ContentField;


class CreateController extends ApiBaseController
{

	public function create( StoreContentField $request )
	{
		$data = $request->all();
		
		$contentField = new ContentField;
		$contentField->fill( $data );
		$contentField->save();

		return response()->json( [ 'result' => 'ok', 'content_field'  => $contentField->toArray() ] );
	}

}
