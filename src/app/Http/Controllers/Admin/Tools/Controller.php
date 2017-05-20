<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Tools;

use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Admin\Controller as MainAdminController;

class Controller extends MainAdminController
{
	protected function validator(array $data)
	{
		$rules = array(
			'page_homepage' => 'required',
		);
		return Validator::make($data, $rules);
	}
}
