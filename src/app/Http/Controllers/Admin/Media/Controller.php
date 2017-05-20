<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Admin\Controller as MainAdminController;

class Controller extends MainAdminController
{
	protected function _save( Request $request, $media )
	{
		$data = $request->all();

		$media->caption     = $data['caption'];
		$media->alt_text    = $data['alt_text'];
		$media->description = $data['description'];
		$media->save();
		return $media;
	}

	protected function validator( Request $request, array $data )
	{
		$rules = array();
		return Validator::make($data, $rules);
	}
}
