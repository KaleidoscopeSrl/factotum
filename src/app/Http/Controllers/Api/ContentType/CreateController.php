<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\ContentType;

class CreateController extends Controller
{

    public function create(Request $request)
    {
        $this->validator( $request, $request->all() )->validate();

        $contentType = new ContentType;
        $this->_save( $request, $contentType );

        return response()->json( [ 'result' => 'ok', 'contentType'  => $contentType->toArray() ] );
    }

}
