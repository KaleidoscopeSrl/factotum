<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentField;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\ContentField;

class UpdateController extends Controller
{

    public function update(Request $request, $id)
    {
        $this->validator( $request->all(), $id )->validate();

        // TODO: ??
        $oldContentField = ContentField::find( $id );
        $contentField = ContentField::find($id);

        $contentField->old_content_field = $oldContentField->name;
        $contentField = $this->_save( $request, $contentField );

        return response()->json( [ 'result' => 'ok', 'contentField'  => $contentField->toArray() ] );
    }

}
