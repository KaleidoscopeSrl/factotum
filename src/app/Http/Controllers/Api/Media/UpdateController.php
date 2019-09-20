<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Media;

class UpdateController extends Controller
{
	public function update(Request $request, $id)
	{
		$data = $request->all();
		$this->validator( $request, $data )->validate();

		$media = Media::find($id);
		$media = $this->_save( $request, $media );

		return response()->json( [ 'result' => 'ok', 'media'  => $media->toArray() ] );

	}

}
