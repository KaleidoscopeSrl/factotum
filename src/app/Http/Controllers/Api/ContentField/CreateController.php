<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentField;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;

class CreateController extends Controller
{

    public function create(Request $request)
    {
        $this->validator( $request->all() )->validate();

        $contentField = new ContentField;
        $contentField = $this->_save( $request, $contentField );

        return response()->json( [ 'result' => 'ok', 'contentField'  => $contentField->toArray() ] );
    }


}
