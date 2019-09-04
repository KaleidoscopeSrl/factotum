<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tools;

use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

class Controller extends ApiBaseController
{
	protected function validator(array $data)
	{
		$rules = array(
			'page_homepage' => 'required',
		);
		return Validator::make($data, $rules);
	}
}
