<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Settings;

use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

class Controller extends ApiBaseController
{
	protected function validator(array $data)
	{
		$rules = array();
		$availableLanguages = config('factotum.factotum.site_languages');
		if ( count($availableLanguages) > 0 ) {
			foreach ($availableLanguages as $lang => $label) {
				$rules[ 'page_' . $lang . '_homepage' ] = 'required';
			}
		}
		return Validator::make($data, $rules);
	}
}
