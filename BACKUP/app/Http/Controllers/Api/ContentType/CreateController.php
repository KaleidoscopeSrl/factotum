<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\ContentType;
use Kaleidoscope\Factotum\Http\Requests\StoreContentType;


class CreateController extends ApiBaseController
{

    public function create(StoreContentType $request)
    {
    	$data = $request->all();

        $contentType = new ContentType;
        $contentType->fill($data);
		$contentType->save();

        return response()->json( [ 'result' => 'ok', 'content_type'  => $contentType->toArray() ] );
    }

}
