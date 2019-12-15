<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Http\Requests\StoreContentType;

class CreateController extends Controller
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
