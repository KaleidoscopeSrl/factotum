<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreContentType;
use Kaleidoscope\Factotum\Models\ContentType;


class UpdateController extends ApiBaseController
{

	public function update(StoreContentType $request, $id)
	{
		$data = $request->all();

		$contentType = ContentType::find($id);
		$contentType->fill($data);
		$contentType->save();

        return response()->json( [ 'result' => 'ok', 'content_type'  => $contentType->toArray() ] );
	}

	public function changeVisibility(StoreContentType $request, $id)
	{
		$contentType = ContentType::find($id);
		$contentType->visible = !$contentType->visible;
		$contentType->save();

		return response()->json( [ 'result' => 'ok', 'content_type'  => $contentType->toArray() ] );
	}

}
