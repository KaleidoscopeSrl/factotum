<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Media;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Media;

class UpdateController extends Controller
{

	public function update( Request $request, $id )
	{
		$media = Media::find($id);

		if ( $media ) {
			$media->fill( $request->all() );
			$media->save();

			return response()->json( [ 'result' => 'ok', 'media'  => $media->toArray() ] );
		}

		return $this->_sendJsonError('Media not found');
	}

}
